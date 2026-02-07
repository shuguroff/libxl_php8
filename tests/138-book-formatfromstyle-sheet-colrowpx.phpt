--TEST--
ExcelBook: addFormatFromStyle, ExcelSheet: setColPx/setRowPx
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'addFormatFromStyle')) die('skip ExcelBook::addFormatFromStyle() not available (LibXL < 4.2.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

// addFormatFromStyle
$format = $book->addFormatFromStyle(ExcelBook::CELLSTYLE_NORMAL);
var_dump($format instanceof ExcelFormat);

$format2 = $book->addFormatFromStyle(ExcelBook::CELLSTYLE_TITLE);
var_dump($format2 instanceof ExcelFormat);

// setColPx — set column width in pixels
var_dump($sheet->setColPx(0, 0, 100));

// setRowPx — set row height in pixels
var_dump($sheet->setRowPx(0, 50));

// setColPx with format and hidden
var_dump($sheet->setColPx(1, 3, 200, false, $format));

// setRowPx with format and hidden
var_dump($sheet->setRowPx(1, 30, $format2, false));

// Verify CellStyle constants exist
var_dump(ExcelBook::CELLSTYLE_NORMAL === 0);
var_dump(is_int(ExcelBook::CELLSTYLE_PERCENT));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
