# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

libxl_php8 — PHP-расширение (PECL-style) для работы с Excel-файлами через библиотеку LibXL. Форк с полной поддержкой PHP 8.x и LibXL 5.x.

**Требования:** PHP 8.2+, LibXL 3.6.0+

## Build & Test (Docker only)

Сборка и тестирование выполняются **только через Docker**. Локальная сборка (phpize/make) не используется.

```bash
# Сборка и тестирование на конкретной версии PHP
docker compose build php83
docker compose up php83

# Проверка компиляции (warnings/errors) — смотреть вывод docker compose build
# Проверка тестов — смотреть вывод docker compose up

# Сборка с лицензией LibXL
LIBXL_LICENSE_NAME="Name" LIBXL_LICENSE_KEY="key" docker compose build
```

**Важно:** Не использовать `make clean` локально — удалит `.so` файлы из `libxl/`.

## Architecture

### Core Files
- `excel.c` — основная реализация (7300+ строк): все классы, методы, константы
- `php_excel.h` — заголовочный файл: макросы, структуры объектов, глобальные переменные модуля
- `config.m4` — конфигурация сборки Unix/Linux

### Object Model

6 классов с иерархией:
- **ExcelBook** — рабочая книга (создание, загрузка, сохранение, шрифты, форматы, изображения)
- **ExcelSheet** — лист (чтение/запись ячеек, форматирование, объединение, печать)
- **ExcelFont** — шрифт (размер, цвет, стиль)
- **ExcelFormat** — формат ячейки (выравнивание, границы, заливка)
- **ExcelAutoFilter** — автофильтр (LibXL 3.7.0+)
- **ExcelFilterColumn** — колонка фильтра (LibXL 3.7.0+)

### Memory Management Pattern

Каждый класс имеет C-структуру:
```c
typedef struct _excel_book_object {
    BookHandle book;           // LibXL дескриптор
    zend_object std;           // Zend объект (ДОЛЖЕН быть последним)
} excel_book_object;
```

Макросы для извлечения объектов:
```c
BOOK_FROM_OBJECT(book, object)
SHEET_FROM_OBJECT(sheet, object)
FONT_FROM_OBJECT(font, object)
FORMAT_FROM_OBJECT(format, object)
```

### Version-Specific Compilation

Условная компиляция для разных версий LibXL:
```c
#if LIBXL_VERSION >= 0x03070000  // AutoFilter, FilterColumn
#if LIBXL_VERSION >= 0x03080000  // addPictureAsLink(), moveSheet()
```

## Testing

Тесты в формате `.phpt` (101 файл в `tests/`). Структура:
```
--TEST--
Description
--SKIPIF--
<?php if (!condition) print "skip"; ?>
--FILE--
<?php // test code ?>
--EXPECT--
Expected output
```

## Documentation

- `docs/` — PHP stub файлы для IDE автодополнения (ExcelBook.php, ExcelSheet.php и др.)
- `README.md` — установка, Docker, примеры

## php.ini Configuration

```ini
[excel]
excel.license_name = "NAME"   ; LibXL лицензия
excel.license_key = "KEY"     ; LibXL ключ
excel.skip_empty = 0          ; 0=нет, 1=пропускать null, 2=+пустые строки
```

## Key Technical Notes

- Trial версия LibXL добавляет водяной знак в первую строку
- Формулы хранятся без вычисленных значений (требуется пересчет в Excel)
- PHP 8 совместимость: `zend_object_alloc()`, `zval_ptr_dtor()`, `ZVAL_DEREF`
