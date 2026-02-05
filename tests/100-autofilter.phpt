--TEST--
ExcelAutoFilter class tests
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03070000) die('skip LibXL 3.7.0+ required');
?>
--FILE--
<?php
// Create xlsx book (autofilter only works with xlsx)
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('AutoFilter Test');

// Write header row
$sheet->write(0, 0, 'Name');
$sheet->write(0, 1, 'Age');
$sheet->write(0, 2, 'City');

// Write data rows
$sheet->write(1, 0, 'Alice');
$sheet->write(1, 1, 25);
$sheet->write(1, 2, 'New York');

$sheet->write(2, 0, 'Bob');
$sheet->write(2, 1, 30);
$sheet->write(2, 2, 'Los Angeles');

$sheet->write(3, 0, 'Charlie');
$sheet->write(3, 1, 35);
$sheet->write(3, 2, 'Chicago');

// Get autofilter object
$autoFilter = $sheet->autoFilter();
var_dump($autoFilter instanceof ExcelAutoFilter);

// Test setRef() and getRef()
$autoFilter->setRef(0, 0, 3, 2);
$ref = $autoFilter->getRef();
var_dump($ref['row_first']);
var_dump($ref['row_last']);
var_dump($ref['col_first']);
var_dump($ref['col_last']);

// Test column() - creates filter column if not exists
$filterColumn = $autoFilter->column(1);
var_dump($filterColumn instanceof ExcelFilterColumn);

// Test columnSize() - should be 1 after creating one column
var_dump($autoFilter->columnSize());

// Test columnByIndex()
$filterColumnByIndex = $autoFilter->columnByIndex(0);
var_dump($filterColumnByIndex instanceof ExcelFilterColumn);

// Test setSort() and getSort()
var_dump($autoFilter->setSort(1, true));
$sort = $autoFilter->getSort();
var_dump($sort['column_index']);
var_dump($sort['descending']);

// Test getSortRange()
$sortRange = $autoFilter->getSortRange();
var_dump(is_array($sortRange));

// Test applyFilter()
var_dump($sheet->applyFilter());

// Test removeFilter()
var_dump($sheet->removeFilter());

echo "OK\n";
?>
--EXPECT--
bool(true)
int(0)
int(3)
int(0)
int(2)
bool(true)
int(1)
bool(true)
bool(true)
int(1)
bool(true)
bool(true)
bool(true)
bool(true)
OK
