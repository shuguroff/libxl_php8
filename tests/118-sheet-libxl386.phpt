--TEST--
ExcelSheet methods for LibXL 3.8.6+
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03080600) die('skip LibXL 3.8.6+ required');
?>
--FILE--
<?php
// Create xlsx book
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Sheet 3.8.6 Test');

// Write some data to ensure sheet has content
$sheet->write(0, 0, 'Test');

// Test colWidthPx() - get column width in pixels
$widthPx = $sheet->colWidthPx(0);
var_dump(is_int($widthPx));
var_dump($widthPx > 0);

// Test rowHeightPx() - get row height in pixels
$heightPx = $sheet->rowHeightPx(0);
var_dump(is_int($heightPx));
var_dump($heightPx > 0);

// Test with custom column width
$sheet->setColWidth(1, 1, 20);
$widthPx2 = $sheet->colWidthPx(1);
var_dump(is_int($widthPx2));
var_dump($widthPx2 > 0);

// Test with custom row height
$sheet->setRowHeight(1, 30);
$heightPx2 = $sheet->rowHeightPx(1);
var_dump(is_int($heightPx2));
var_dump($heightPx2 > 0);

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
