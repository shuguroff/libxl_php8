# Plan: Add missing LibXL API methods (v3.9.0 -- v5.1.0)

## Context

PHP-extension libxl_php8 wraps LibXL C API up to version 3.8.6. Locally installed LibXL is v5.1.0 (267 C functions across 12 types). Since v3.8.6, LibXL added **6 new object types** and **~130 new C functions** not exposed to PHP.

Goal: add all missing APIs -- 6 new PHP classes, ~177 new methods, ~5000 lines of C code. New classes go into separate .c files.

### Key requirements

1. **Тест на каждый метод.** Каждый добавленный PHP-метод должен иметь хотя бы один phpt-тест. Тесты группируются по классам/фазам: один phpt-файл может тестировать несколько связанных методов одного класса.

2. **Обратная совместимость.** Расширение должно компилироваться и работать с любой версией LibXL >= 3.6.0:
   - Весь новый код оборачивается в `#if LIBXL_VERSION >= 0xNNNNNNNN` / `#endif`
   - Регистрация классов, методов и констант — тоже внутри guards
   - Тесты используют `--SKIPIF--` с проверкой `LIBXL_VERSION` или наличия класса/метода:
     ```php
     --SKIPIF--
     <?php
     if (!method_exists('ExcelSheet', 'firstFilledRow')) print "skip LibXL < 3.9.1";
     ?>
     ```
   - `config.m4`: новые .c файлы включаются безусловно (они содержат пустые заглушки при отсутствии нужной версии)

---

## Phase 0: Infrastructure + missing pre-3.9 functions

### 0.1 Refactor php_excel.h for multi-file support

Move from `excel.c` to `php_excel.h`:
- All `typedef struct` for object types (existing + new)
- All `inline` fetch functions (`php_excel_book_object_fetch`, etc.)
- All `*_FROM_OBJECT` macros
- `extern` declarations for `zend_class_entry*` and `zend_object_handlers`
- `extern zend_class_entry *excel_ce_exception`

### 0.2 Add missing functions from already-supported API versions

**ExcelBook (3 methods):**
- `version(): int` -- `xlBookVersion()`
- `isWriteProtected(): bool` -- `xlBookIsWriteProtected()`
- `loadWithoutEmptyCells(string $filename): bool` -- `xlBookLoadWithoutEmptyCells()`

**ExcelSheet (3 methods):**
- `defaultRowHeight(): float` -- `xlSheetDefaultRowHeight()`
- `setDefaultRowHeight(float $height): void` -- `xlSheetSetDefaultRowHeight()`
- `writeStrAsNum(int $row, int $col, string $value, ?ExcelFormat $format = null): bool` -- `xlSheetWriteStrAsNum()`

### 0.3 Update config.m4

Add all new .c files to `PHP_NEW_EXTENSION`:
```
PHP_NEW_EXTENSION(excel, excel.c excel_richstring.c excel_formcontrol.c excel_condformat.c excel_coreprops.c excel_table.c, $ext_shared)
```

**Files:** `php_excel.h`, `excel.c`, `config.m4`
**Tests:** 3 phpt files (по одному на ExcelBook, ExcelSheet группы методов + инфраструктурный)

---

## Phase 1: v3.9.0 -- RichString class + Book/Sheet additions

**Guard:** `#if LIBXL_VERSION >= 0x03090000`
**New file:** `excel_richstring.c`

### New class: ExcelRichString (4 methods)

```c
typedef struct _excel_richstring_object {
    RichStringHandle richstring;
    BookHandle book;
    zend_object std;
} excel_richstring_object;
```

| PHP method | C API | Returns |
|---|---|---|
| `addFont(?ExcelFont $init = null): ExcelFont` | `xlRichStringAddFont` | FontHandle -> ExcelFont |
| `addText(string $text, ?ExcelFont $font = null): bool` | `xlRichStringAddText` | int |
| `getText(int $index): array{text: string, font: ExcelFont}` | `xlRichStringGetText` | string + FontHandle |
| `textSize(): int` | `xlRichStringTextSize` | int |

### ExcelBook additions (3 methods) -- in `excel.c`
- `addRichString(): ExcelRichString`
- `calcMode(): int` / `setCalcMode(int $mode): void`

### ExcelSheet additions (5 methods) -- in `excel.c`
- `isRichStr(row, col): bool`, `readRichStr(row, col): ExcelRichString|false`, `writeRichStr(row, col, rs, ?format): bool`
- `removePicture(row, col): bool`, `removePictureByIndex(index): bool`

### Constants: `CalcModeType` (3 values)

**Files:** `excel_richstring.c`, `excel.c`, `php_excel.h`, `docs/ExcelRichString.php`
**Tests:** 4 phpt files (RichString 4 метода, Book 3 метода, Sheet 5 методов, constants)

---

## Phase 2: v3.9.1 -- Filled Row/Col boundaries

**Guard:** `#if LIBXL_VERSION >= 0x03090100`

### ExcelSheet additions (4 methods) -- in `excel.c`
- `firstFilledRow(): int`, `lastFilledRow(): int`, `firstFilledCol(): int`, `lastFilledCol(): int`

**Tests:** 1 phpt file

---

## Phase 3: v4.0.0 -- FormControl class

**Guard:** `#if LIBXL_VERSION >= 0x04000000`
**New file:** `excel_formcontrol.c`

### New class: ExcelFormControl (41 methods)

```c
typedef struct _excel_formcontrol_object {
    FormControlHandle formcontrol;
    SheetHandle sheet;
    BookHandle book;
    zend_object std;
} excel_formcontrol_object;
```

Methods (grouped):
- **Type:** `objectType(): int`
- **Checkbox:** `checked(): int` / `setChecked(int): void`
- **Formulas (4 pairs):** `fmlaGroup/set`, `fmlaLink/set`, `fmlaRange/set`, `fmlaTxbx/set`
- **Read-only strings (5):** `name`, `linkedCell`, `listFillRange`, `macro`, `altText`
- **Read-only bools (4):** `locked`, `defaultSize`, `print`, `disabled`
- **List items (5):** `item(i)`, `itemSize()`, `addItem(v)`, `insertItem(i,v)`, `clearItems()`
- **Numeric get/set (7 pairs):** `dropLines`, `dx`, `firstButton`, `horiz`, `inc`, `getMax/getMin`, `sel`
- **String get/set:** `multiSel/setMultiSel`
- **Anchors (2):** `fromAnchor(): array`, `toAnchor(): array`

### ExcelSheet additions (2 methods) -- in `excel.c`
- `formControlSize(): int`, `formControl(int $index): ExcelFormControl|false`

### ExcelAutoFilter additions (1 method) -- in `excel.c`
- `addSort(int $columnIndex, bool $descending = false): bool`

### Constants: `ObjectType` (12 values), `CheckedType` (3 values)

**Files:** `excel_formcontrol.c`, `excel.c`, `php_excel.h`, `docs/ExcelFormControl.php`
**Tests:** 6 phpt files (FormControl getter/setter группы, Sheet formControl, AutoFilter addSort, items, anchors, formulas)

---

## Phase 4: v4.1.0 -- ConditionalFormat + ConditionalFormatting

**Guard:** `#if LIBXL_VERSION >= 0x04010000`
**New file:** `excel_condformat.c` (both classes)

### New class: ExcelConditionalFormat (27 methods)

```c
typedef struct _excel_condformat_object {
    ConditionalFormatHandle condformat;
    BookHandle book;
    zend_object std;
} excel_condformat_object;
```

`font(): ExcelFont`, numFormat get/set, customNumFormat get/set, setBorder/setBorderColor, border sides (4x style+color get/set = 16), fill pattern + fg/bg color (3 get/set pairs)

### New class: ExcelConditionalFormatting (11 methods)

```c
typedef struct _excel_condformatting_object {
    ConditionalFormattingHandle condformatting;
    SheetHandle sheet;
    BookHandle book;
    zend_object std;
} excel_condformatting_object;
```

`addRange`, `addRule`, `addTopRule`, `addOpNumRule`, `addOpStrRule`, `addAboveAverageRule`, `addTimePeriodRule`, `add2ColorScaleRule`, `add2ColorScaleFormulaRule`, `add3ColorScaleRule`, `add3ColorScaleFormulaRule`

### ExcelBook additions (1) -- `addConditionalFormat(): ExcelConditionalFormat`
### ExcelSheet additions (8) -- `addConditionalFormatting()`, `getActiveCell/setActiveCell`, `selectionRange/addSelectionRange/removeSelection`, `tabColor(): int`, `getTabRgbColor(): array`

### Constants: `CFormatType` (11), `CFormatOperator` (12), `CFormatTimePeriod` (10), `CFVOType` (6)

**Files:** `excel_condformat.c`, `excel.c`, `php_excel.h`, `docs/ExcelConditionalFormat.php`, `docs/ExcelConditionalFormatting.php`
**Tests:** 6 phpt files (ConditionalFormat font/border/fill/numFormat, ConditionalFormatting rules, Sheet additions)

---

## Phase 5: v4.1.2 -- v4.4.0 -- Small additions

All in `excel.c`.

- **v4.1.2:** `Sheet::hyperlinkIndex(row, col): int`
- **v4.2.0:** `Book::addFormatFromStyle(int $style): ExcelFormat`, `Sheet::setColPx(...)`, `Sheet::setRowPx(...)`
- **v4.3.0:** `Book::removeVBA(): bool`, `Book::removePrinterSettings(): bool`
- **v4.4.0:** `Book::dpiAwareness(): int` / `Book::setDpiAwareness(int): void`

### Constants: `CellStyle` (50 values)

**Tests:** 4 phpt files (hyperlinkIndex, formatFromStyle+setColPx+setRowPx, removeVBA+removePrinterSettings, dpiAwareness)

---

## Phase 6: v4.5.0 -- CoreProperties class

**Guard:** `#if LIBXL_VERSION >= 0x04050000`
**New file:** `excel_coreprops.c`

### New class: ExcelCoreProperties (23 methods)

```c
typedef struct _excel_coreproperties_object {
    CorePropertiesHandle coreproperties;
    BookHandle book;
    zend_object std;
} excel_coreproperties_object;
```

String get/set pairs: title, subject, creator, lastModifiedBy, created, modified, tags, categories, comments. Double get/set: createdAsDouble, modifiedAsDouble. Plus `removeAll()`.

### ExcelBook additions (2) -- `coreProperties(): ExcelCoreProperties` (XLSX only), `removeAllPhonetics(): void`
### ExcelSheet additions (2) -- `colFormat(col): ExcelFormat|false`, `rowFormat(row): ExcelFormat|false`
### v4.5.1 -- `Sheet::setBorder(rowFirst, rowLast, colFirst, colLast, style, color): bool`

**Files:** `excel_coreprops.c`, `excel.c`, `php_excel.h`, `docs/ExcelCoreProperties.php`
**Tests:** 5 phpt files (CoreProperties string props, double props, removeAll, Sheet colFormat/rowFormat+setBorder, Book additions)

---

## Phase 7: v4.6.0 -- Table class

**Guard:** `#if LIBXL_VERSION >= 0x04060000`
**New file:** `excel_table.c`

### New class: ExcelTable (15 methods)

```c
typedef struct _excel_table_object {
    TableHandle table;
    SheetHandle sheet;
    BookHandle book;
    zend_object std;
} excel_table_object;
```

`name/setName`, `ref/setRef`, `autoFilter(): ExcelAutoFilter`, `style/setStyle`, `showRowStripes/set`, `showColumnStripes/set`, `showFirstColumn/set`, `showLastColumn/set`, `columnSize()`, `columnName(i)/setColumnName(i, name)`

### ExcelSheet additions (4) -- `addTable(...)`, `getTableByName(name)`, `getTableByIndex(index)`, `applyFilter2(autofilter)`

### Constants: `TableStyle` (60 values)

**Files:** `excel_table.c`, `excel.c`, `php_excel.h`, `docs/ExcelTable.php`
**Tests:** 5 phpt files (Table create+name/ref, Table style+stripes, Table columns, Sheet addTable/getTable, applyFilter2)

---

## Phase 8: v5.0.0 -- v5.1.0 -- Final additions

- **v5.0.0:** `Book::setPassword(string): void`
- **v5.0.1:** `Book::loadInfoRaw(string $data): bool`
- **v5.1.0:** `Book::errorCode(): int`, `Book::conditionalFormat(index)`, `Book::conditionalFormatSize()`, `Book::clear()`, `Sheet::conditionalFormatting(index)`, `Sheet::removeConditionalFormatting(index)`, `Sheet::conditionalFormattingSize()`

### Known bug in libxl.h v5.1.0

Lines 287-290, 789-790: macros `xlSheetRemoveConditionalFormatting` and `xlSheetConditionalFormattingSize` both incorrectly point to `xlSheetConditionalFormatting`. Fix:
```c
#undef xlSheetRemoveConditionalFormatting
#undef xlSheetConditionalFormattingSize
#define xlSheetRemoveConditionalFormatting xlSheetRemoveConditionalFormattingA
#define xlSheetConditionalFormattingSize xlSheetConditionalFormattingSizeA
```

### Constants: `ErrorCode` (80+ values)

**Tests:** 4 phpt files (setPassword, loadInfoRaw, errorCode+clear, conditionalFormat/Formatting Book+Sheet)

---

## Summary

| Phase | Methods | New classes | New file | Est. lines | Tests |
|-------|---------|------------|----------|-----------|-------|
| 0 | 6 | 0 | -- | 200 | 3 |
| 1 | 12 | ExcelRichString | excel_richstring.c | 400 | 4 |
| 2 | 4 | -- | -- | 80 | 1 |
| 3 | 44 | ExcelFormControl | excel_formcontrol.c | 1200 | 6 |
| 4 | 47 | ExcelConditionalFormat, ExcelConditionalFormatting | excel_condformat.c | 1400 | 6 |
| 5 | 8 | -- | -- | 250 | 4 |
| 6 | 28 | ExcelCoreProperties | excel_coreprops.c | 600 | 5 |
| 7 | 19 | ExcelTable | excel_table.c | 500 | 5 |
| 8 | 9 | -- | -- | 300 | 4 |
| **Total** | **~177** | **6** | **5 files** | **~4930** | **~38** |

## Backward Compatibility Strategy

### C-код
- Каждый блок нового кода оборачивается в `#if LIBXL_VERSION >= 0xVVVVVVVV` / `#endif`
- Новые .c файлы: весь контент внутри `#if` guard, при старой версии LibXL файл компилируется в пустой объект
- Новые struct-типы, class entries, object handlers — всё внутри guards
- Пример скелета нового файла:
  ```c
  #include "php_excel.h"
  #if LIBXL_VERSION >= 0x03090000
  // ... весь код класса ...
  void excel_richstring_register(void) { /* регистрация */ }
  #else
  void excel_richstring_register(void) { /* noop */ }
  #endif
  ```
- В `MINIT` вызов `excel_richstring_register()` безусловный — функция сама решает, что регистрировать

### Тесты
- Каждый phpt-тест для нового API содержит `--SKIPIF--`:
  ```php
  <?php if (!method_exists('ExcelSheet', 'firstFilledRow')) print "skip"; ?>
  ```
  или для новых классов:
  ```php
  <?php if (!class_exists('ExcelRichString')) print "skip"; ?>
  ```

## Verification

After each phase:
1. `make clean && make 2>&1 | grep -E "warning:|error:" | grep -v "ld:"` -- compile without warnings
2. `make test` -- run all existing + new tests
3. `php -d extension=excel.so -r "var_dump(class_exists('ExcelRichString'));"` -- verify class registration
4. Docker: `docker compose build && docker compose up` -- cross-version PHP testing
