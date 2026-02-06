--TEST--
ExcelSheet::writeFormula() with precalculated values
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03070000) die('skip LibXL 3.7.0+ required');
?>
--FILE--
<?php
// Create xlsx book
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Formula Test');

// Write some values for formulas to reference
$sheet->write(0, 0, 10);
$sheet->write(0, 1, 20);
$sheet->write(0, 2, 'Hello');
$sheet->write(0, 3, 'World');

// Test 1: writeFormula without precalculated value
var_dump($sheet->writeFormula(1, 0, "A1+B1"));

// Test 2: writeFormula with precalculated numeric value (double)
var_dump($sheet->writeFormula(2, 0, "A1+B1", null, 30.0));

// Test 3: writeFormula with precalculated numeric value (int)
var_dump($sheet->writeFormula(3, 0, "A1*B1", null, 200));

// Test 4: writeFormula with precalculated string value
var_dump($sheet->writeFormula(4, 0, "CONCAT(C1,D1)", null, "HelloWorld"));

// Test 5: writeFormula with precalculated boolean value (true)
var_dump($sheet->writeFormula(5, 0, "A1>B1", null, false));

// Test 6: writeFormula with precalculated boolean value (false)
var_dump($sheet->writeFormula(6, 0, "A1<B1", null, true));

// Test 7: writeFormula with format
$format = $book->addFormat();
var_dump($sheet->writeFormula(7, 0, "SUM(A1:B1)", $format, 30));

// Test 8: Verify cell contains formula
var_dump($sheet->isFormula(1, 0));
var_dump($sheet->isFormula(2, 0));

// Test 9: Read formula back
$value = $sheet->read(1, 0);
var_dump(is_string($value) && strpos($value, 'A1+B1') !== false);

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
OK
