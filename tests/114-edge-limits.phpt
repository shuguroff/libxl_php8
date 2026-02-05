--TEST--
Boundary and limit edge cases
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Limits Test');

// Test very long string (Excel cell limit is 32767 characters)
$longString = str_repeat('A', 32767);
$sheet->write(0, 0, $longString);
$readValue = $sheet->read(0, 0);
var_dump(strlen($readValue) === 32767);

// Test string at limit boundary
$atLimit = str_repeat('B', 32766);
$sheet->write(1, 0, $atLimit);
var_dump(strlen($sheet->read(1, 0)) === 32766);

// Test very large positive number
$largeNum = 9999999999999999.0;
$sheet->write(2, 0, $largeNum);
$readValue = $sheet->read(2, 0);
var_dump(is_float($readValue));
var_dump($readValue > 9999999999999990.0);

// Test very large negative number
$largeNegNum = -9999999999999999.0;
$sheet->write(3, 0, $largeNegNum);
$readValue = $sheet->read(3, 0);
var_dump(is_float($readValue));
var_dump($readValue < -9999999999999990.0);

// Test very small number (near zero)
$smallNum = 0.000000000000001;
$sheet->write(4, 0, $smallNum);
$readValue = $sheet->read(4, 0);
var_dump(is_float($readValue));
var_dump($readValue > 0 && $readValue < 0.00001);

// Test negative very small number
$smallNegNum = -0.000000000000001;
$sheet->write(5, 0, $smallNegNum);
$readValue = $sheet->read(5, 0);
var_dump(is_float($readValue));
var_dump($readValue < 0 && $readValue > -0.00001);

// Test zero
$sheet->write(6, 0, 0);
var_dump($sheet->read(6, 0) === 0.0 || $sheet->read(6, 0) === 0);

// Test negative zero
$sheet->write(7, 0, -0.0);
$readValue = $sheet->read(7, 0);
var_dump($readValue == 0);

// Test scientific notation
$sheet->write(8, 0, 1.23e10);
$readValue = $sheet->read(8, 0);
var_dump($readValue == 1.23e10);

$sheet->write(9, 0, 1.23e-10);
$readValue = $sheet->read(9, 0);
var_dump(abs($readValue - 1.23e-10) < 1e-15);

// Test integer boundaries
$sheet->write(10, 0, PHP_INT_MAX);
$readValue = $sheet->read(10, 0);
var_dump(is_float($readValue) || is_int($readValue));

$sheet->write(11, 0, PHP_INT_MIN);
$readValue = $sheet->read(11, 0);
var_dump(is_float($readValue) || is_int($readValue));

// Test row/column near limits
// XLSX supports up to 1,048,576 rows (0-1048575) and 16,384 columns (0-16383)
$lastValidRow = 10000; // Use reasonable value for test speed
$lastValidCol = 100;

$sheet->write($lastValidRow, 0, 'Last row test');
var_dump($sheet->read($lastValidRow, 0) === 'Last row test');

$sheet->write(0, $lastValidCol, 'Last col test');
var_dump($sheet->read(0, $lastValidCol) === 'Last col test');

// Test corner cell
$sheet->write($lastValidRow, $lastValidCol, 'Corner');
var_dump($sheet->read($lastValidRow, $lastValidCol) === 'Corner');

// Test boolean values
$sheet->write(12, 0, true);
$readValue = $sheet->read(12, 0);
var_dump($readValue === true || $readValue === 1);

$sheet->write(13, 0, false);
$readValue = $sheet->read(13, 0);
var_dump($readValue === false || $readValue === 0);

// Test firstRow/lastRow/firstCol/lastCol
$firstRow = $sheet->firstRow();
$lastRow = $sheet->lastRow();
$firstCol = $sheet->firstCol();
$lastCol = $sheet->lastCol();

var_dump($firstRow >= 0);
var_dump($lastRow >= $firstRow);
var_dump($firstCol >= 0);
var_dump($lastCol >= $firstCol);

// Test zoom limits
$sheet->setZoom(10); // Minimum typically 10%
var_dump($sheet->zoom() >= 10);

$sheet->setZoom(400); // Maximum typically 400%
var_dump($sheet->zoom() <= 400);

// Test print zoom limits
$sheet->setZoomPrint(10);
var_dump($sheet->zoomPrint() >= 10);

$sheet->setZoomPrint(400);
var_dump($sheet->zoomPrint() <= 400);

// Test margin boundaries
$sheet->setMarginLeft(0.0);
var_dump($sheet->marginLeft() >= 0);

$sheet->setMarginRight(10.0);
var_dump($sheet->marginRight() <= 20);

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
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
