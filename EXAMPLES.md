# PHP Examples for libxl_php8

This document describes all PHP examples available in the `examples/` directory. These examples demonstrate various features of the libxl_php8 extension, ported from the official LibXL C++ examples.

## Basic Operations

### [write-excel-data.php](examples/write-excel-data.php)

Creates a complete sales receipt with:
- Custom fonts (Century Gothic, various sizes)
- Formatted cells with borders, colors, and alignments
- Date formatting with custom date patterns
- Phone number formatting
- Formulas for calculations (SUM, multiplication)
- Merged cells for headers
- Logo image insertion

**Output:** `receipt.xls`

### [read-excel-data.php](examples/read-excel-data.php)

Demonstrates how to read data from Excel files:
- Iterates through all rows and columns
- Detects and handles different cell types (number, string, boolean, empty, blank, error)
- Reads formulas and displays them
- Outputs data to console

### [place-picture.php](examples/place-picture.php)

Shows how to insert images into worksheets:
- Adding pictures from files using `addPictureFromFile()`
- Scaling pictures with `addPictureScaled()`
- Setting exact dimensions with `addPictureDim()`

**Output:** `picture.xls`

### [get-picture.php](examples/get-picture.php)

Demonstrates extracting images from Excel files:
- Loading an existing workbook
- Getting picture information (position, size)
- Extracting picture data in original format
- Saving pictures to files

### [write-formulas.php](examples/write-formulas.php)

Shows various formula examples:
- SUM, AVERAGE, MAX, MIN aggregate functions
- IF conditional formulas
- CONCATENATE text formulas

**Output:** `formulas.xls`

### [datetime.php](examples/datetime.php)

Working with dates and times:
- Creating date values using `packDateValues()`
- Formatting dates with built-in and custom formats
- Writing dates, times, and datetimes
- Reading and unpacking dates back to timestamps

**Output:** `datetime.xls`

### [sheet-by-name.php](examples/sheet-by-name.php)

Accessing worksheets by different methods:
- Getting sheet by index
- Finding sheet by name using `getSheetByName()`
- Getting total sheet count
- Iterating through all sheets

### [merging.php](examples/merging.php)

Demonstrates cell merging:
- Merging cells for titles and headers
- Creating centered merged regions
- Applying formats to merged cells

**Output:** `merging.xls`

### [grouping.php](examples/grouping.php)

Row and column grouping (outlining):
- Grouping rows (e.g., 1-3, 4-6)
- Grouping columns
- Setting summary position (below/above, right/left)

**Output:** `grouping.xls`

### [insert-row-col.php](examples/insert-row-col.php)

Inserting rows and columns:
- Inserting multiple rows
- Inserting multiple columns
- Adjusting row heights and column widths after insertion

**Output:** `insert-row-col.xls`

### [num-formats.php](examples/num-formats.php)

Using number formats:
- Currency formatting
- Percentage formatting
- Date formatting
- Scientific notation
- Custom number formats

**Output:** `num-formats.xls`

### [formats.php](examples/formats.php)

Cell formatting options:
- Horizontal alignment (left, center, right)
- Vertical alignment (top, middle, bottom)
- Border styles and colors
- Background fill patterns and colors

**Output:** `formats.xls`

### [fonts.php](examples/fonts.php)

Custom font settings:
- Font families (Arial, Times New Roman, Courier New, Verdana, Georgia)
- Font sizes
- Bold, italic styles
- Underline styles
- Font colors

**Output:** `fonts.xls`

### [copying-cells.php](examples/copying-cells.php)

Copying cells between workbooks with formats:
- Copying column widths
- Copying merged cell ranges
- Copying formats between workbooks
- Handling different cell types (numbers, strings, booleans, blanks)

**Output:** `out.xls`

## Memory Buffers

### [buffer1.php](examples/buffer1.php) - Writing to Memory

Creates an Excel file and saves it to a PHP string (memory buffer) instead of a file. Useful for:
- Web applications sending files directly to browser
- Storing Excel data in databases
- Processing files without disk I/O

### [buffer2.php](examples/buffer2.php) - Reading from Memory

Loads an Excel file from a memory buffer (string) instead of a file:
- Reads binary data from file
- Loads into ExcelBook using `load()`
- Reads and displays cell data

## Sheet Protection

### [protection.php](examples/protection.php)

Protects worksheets from modifications:
- Setting protection with password
- Using different protection levels
- Checking if sheet is protected

**Output:** `protected.xls`

## Text Operations

### [replacing.php](examples/replacing.php)

Demonstrates finding and replacing text:
- Loading existing workbook
- Iterating through all cells
- Finding and replacing text strings
- Saving modified workbook

**Output:** `after-replace.xls`

### [rich-string.php](examples/rich-string.php)

Creates rich text strings with multiple fonts in a single cell:
- Creating `ExcelRichString` objects
- Adding text segments with different fonts
- Writing rich strings to cells
- Combining bold, italic, and colored text

**Output:** `rich-string.xls`

## AutoFilter Examples

### [top-n-filter.php](examples/top-n-filter.php)

Filters the top N items in a column:
- Setting up auto filter range
- Using `setTop10()` to filter top 5 values
- Creating formatted headers

**Output:** `top-n-filter.xlsx`

### [sort-filter.php](examples/sort-filter.php)

Sorting data within auto filter:
- Setting filter range
- Using `setSort()` to sort by a specific column
- Ascending and descending order

**Output:** `sort-filter.xlsx`

### [string-filter.php](examples/string-filter.php)

Filtering by string criteria:
- Using custom filters with string operators
- Filtering for exact matches
- Setting up multi-column filters

**Output:** `string-filter.xlsx`

### [number-filter.php](examples/number-filter.php)

Filtering by numeric conditions:
- Using comparison operators (greater than, less than, between)
- Setting numeric filter criteria
- Combining with column ranges

**Output:** `number-filter.xlsx`

### [values-filter.php](examples/values-filter.php)

Filtering by specific values:
- Adding multiple filter values
- Selecting specific items from a list
- Creating OR conditions for filtering

**Output:** `values-filter.xlsx`

## Conditional Formatting Examples

### [begin-with.php](examples/begin-with.php)

Highlights cells that begin with specific text:
- Using `addOpStrRule()` with `CFOPERATOR_CONTAINSTEXT`
- Applying conditional formatting styles
- Creating highlight formats

**Output:** `begin-with.xlsx`

### [color-scale.php](examples/color-scale.php)

Creates gradated color scales:
- Using `add3ColorScaleRule()`
- Setting minimum, median, and maximum values
- Applying different colors based on cell values

**Output:** `color-scale.xlsx`

### [op-rule.php](examples/op-rule.php)

Highlights cells based on operations:
- Using `addOpNumRule()` for numeric comparisons
- Greater than, less than, between operators
- Applying highlight formats

**Output:** `op-rule.xlsx`

### [alt-rows.php](examples/alt-rows.php)

Creates alternating row colors (zebra striping):
- Manually applying different formats to even/odd rows
- Setting header styles
- Creating clean data presentation

**Output:** `alt-rows.xlsx`

## Running the Examples

All examples output files to the `examples/` directory. To run an example:

```bash
php examples/example-name.php
```

Note: Some examples require:
- An input file (e.g., `input.xls`) to exist in the examples directory
- An image file (`logo.png` or `image.png`) for picture examples
- The `excel.so` extension to be loaded

For Docker-based testing:

```bash
docker compose build php83
docker compose up php83
```

## Notes

- Examples output `.xls` files by default (BIFF8 format). Use `new ExcelBook(null, null, true)` for XLSX format.
- Some advanced features (AutoFilter, Conditional Formatting) require XLSX format.
- All examples include proper error handling where applicable.
- Examples are compatible with PHP 8.2+ and libxl_php8 extension.
