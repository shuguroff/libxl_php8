--TEST--
ExcelFilterColumn class tests
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03070000) die('skip LibXL 3.7.0+ required');
?>
--FILE--
<?php
// Create xlsx book (filter column only works with xlsx)
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('FilterColumn Test');

// Write header row
$sheet->write(0, 0, 'Category');
$sheet->write(0, 1, 'Value');

// Write data rows
$sheet->write(1, 0, 'A');
$sheet->write(1, 1, 10);

$sheet->write(2, 0, 'B');
$sheet->write(2, 1, 20);

$sheet->write(3, 0, 'A');
$sheet->write(3, 1, 30);

// Get autofilter and set range
$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 0, 3, 1);

// Get filter column
$filterColumn = $autoFilter->column(0);
var_dump($filterColumn instanceof ExcelFilterColumn);

// Test index()
var_dump($filterColumn->index());

// Test filterType() - should be FILTER_NOT_SET initially
var_dump($filterColumn->filterType() === ExcelFilterColumn::FILTER_NOT_SET);

// Test addFilter() and filterSize()
$filterColumn->addFilter('A');
var_dump($filterColumn->filterSize());

$filterColumn->addFilter('B');
var_dump($filterColumn->filterSize());

// Test filter() - get filter value by index
var_dump($filterColumn->filter(0));
var_dump($filterColumn->filter(1));

// Test filterType() - should be FILTER_VALUE after adding filters
var_dump($filterColumn->filterType() === ExcelFilterColumn::FILTER_VALUE);

// Test clear()
var_dump($filterColumn->clear());

// filterSize should be 0 after clear
var_dump($filterColumn->filterSize());

// Test setTop10() and getTop10()
$filterColumn2 = $autoFilter->column(1);
var_dump($filterColumn2->setTop10(5.0, true, false));

$top10 = $filterColumn2->getTop10();
var_dump($top10['value']);
var_dump($top10['top']);
var_dump($top10['percent']);

// Test filterType() - should be FILTER_TOP10 after setTop10
var_dump($filterColumn2->filterType() === ExcelFilterColumn::FILTER_TOP10);

// Clear and test setCustomFilter()
$filterColumn2->clear();

$filterColumn2->setCustomFilter(
    ExcelFilterColumn::OPERATOR_GREATER_THAN,
    '10',
    ExcelFilterColumn::OPERATOR_LESS_THAN,
    '30',
    true  // AND operator
);

// Test getCustomFilter()
$customFilter = $filterColumn2->getCustomFilter();
var_dump($customFilter['operator_1'] === ExcelFilterColumn::OPERATOR_GREATER_THAN);
var_dump($customFilter['value_1']);
var_dump($customFilter['operator_2'] === ExcelFilterColumn::OPERATOR_LESS_THAN);
var_dump($customFilter['value_2']);
var_dump($customFilter['andOp']);

// Test filterType() - should be FILTER_CUSTOM after setCustomFilter
var_dump($filterColumn2->filterType() === ExcelFilterColumn::FILTER_CUSTOM);

// Test constants
var_dump(ExcelFilterColumn::FILTER_VALUE);
var_dump(ExcelFilterColumn::FILTER_TOP10);
var_dump(ExcelFilterColumn::FILTER_CUSTOM);
var_dump(ExcelFilterColumn::FILTER_NOT_SET);
var_dump(ExcelFilterColumn::OPERATOR_EQUAL);
var_dump(ExcelFilterColumn::OPERATOR_GREATER_THAN);
var_dump(ExcelFilterColumn::OPERATOR_LESS_THAN);
var_dump(ExcelFilterColumn::OPERATOR_NOT_EQUAL);

echo "OK\n";
?>
--EXPECT--
bool(true)
int(0)
bool(true)
int(1)
int(2)
string(1) "A"
string(1) "B"
bool(true)
bool(true)
int(0)
bool(true)
float(5)
bool(true)
bool(false)
bool(true)
bool(true)
string(2) "10"
bool(true)
string(2) "30"
bool(true)
bool(true)
int(0)
int(1)
int(2)
int(7)
int(0)
int(1)
int(3)
int(5)
OK
