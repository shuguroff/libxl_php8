--TEST--
ExcelSheet::defaultRowHeight() and setDefaultRowHeight()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'defaultRowHeight')) die('skip ExcelSheet::defaultRowHeight() not available');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// defaultRowHeight() returns a float on a fresh sheet
$h = $sheet->defaultRowHeight();
var_dump(is_float($h) || is_int($h));
var_dump($h > 0);

// setDefaultRowHeight() changes the value
$sheet->setDefaultRowHeight(25.5);
$h2 = $sheet->defaultRowHeight();
var_dump(abs($h2 - 25.5) < 0.01);

// Also test with XLS
$bookXls = new ExcelBook(null, null, false);
$sheetXls = $bookXls->addSheet('Test');
$hXls = $sheetXls->defaultRowHeight();
var_dump(is_float($hXls) || is_int($hXls));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
OK
