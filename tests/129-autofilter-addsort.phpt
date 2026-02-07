--TEST--
ExcelAutoFilter::addSort()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelAutoFilter', 'addSort')) die('skip ExcelAutoFilter::addSort() not available (LibXL < 4.0.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// Write header + data
$sheet->write(0, 0, 'Name');
$sheet->write(0, 1, 'Value');
$sheet->write(1, 0, 'A');
$sheet->write(1, 1, 10);
$sheet->write(2, 0, 'B');
$sheet->write(2, 1, 20);

// Create autofilter via constructor (Sheet::autoFilter() has a known RETURN_TRUE bug)
$autoFilter = new ExcelAutoFilter($sheet);
$autoFilter->setRef(0, 2, 0, 1);

// addSort() returns bool
$result = $autoFilter->addSort(1, false);
var_dump(is_bool($result));
var_dump($result);

// addSort with descending
$result2 = $autoFilter->addSort(0, true);
var_dump(is_bool($result2));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
OK
