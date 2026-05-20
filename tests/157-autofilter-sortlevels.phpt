--TEST--
ExcelAutoFilter::sortLevels() and getSort(level)
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelAutoFilter', 'sortLevels')) die('skip ExcelAutoFilter::sortLevels() not available (LibXL < 5.2.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('SortLevels');

$sheet->write(0, 0, 'Name');
$sheet->write(0, 1, 'Score');
$sheet->write(0, 2, 'City');
$sheet->write(1, 0, 'Alice');
$sheet->write(1, 1, 90);
$sheet->write(1, 2, 'Paris');
$sheet->write(2, 0, 'Bob');
$sheet->write(2, 1, 75);
$sheet->write(2, 2, 'Rome');

$af = $sheet->autoFilter();
$af->setRef(0, 2, 0, 2);

var_dump($af->addSort(1, true));
var_dump($af->addSort(2, false));
var_dump($af->sortLevels());

$sort0 = $af->getSort(0);
var_dump($sort0['column_index']);
var_dump($sort0['descending']);

$sort1 = $af->getSort(1);
var_dump($sort1['column_index']);
var_dump($sort1['descending']);

var_dump($af->getSort(99));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
int(2)
int(1)
bool(true)
int(2)
bool(false)
bool(false)
OK
