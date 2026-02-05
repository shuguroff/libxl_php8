--TEST--
ExcelSheet group summary and named range methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Groups Test');

// Write some data for grouping
for ($i = 0; $i < 10; $i++) {
    $sheet->write($i, 0, "Row $i");
    $sheet->write(0, $i, "Col $i");
}

// Test getGroupSummaryRight() default value
var_dump($sheet->getGroupSummaryRight());

// Test setGroupSummaryRight()
var_dump($sheet->setGroupSummaryRight(false));
var_dump($sheet->getGroupSummaryRight());

var_dump($sheet->setGroupSummaryRight(true));
var_dump($sheet->getGroupSummaryRight());

// Test getGroupSummaryBelow() default value
var_dump($sheet->getGroupSummaryBelow());

// Test setGroupSummaryBelow()
var_dump($sheet->setGroupSummaryBelow(false));
var_dump($sheet->getGroupSummaryBelow());

var_dump($sheet->setGroupSummaryBelow(true));
var_dump($sheet->getGroupSummaryBelow());

// Test groupRows()
var_dump($sheet->groupRows(1, 3, false)); // Group rows 1-3, not collapsed
var_dump($sheet->groupRows(5, 7, true));  // Group rows 5-7, collapsed

// Test groupCols()
var_dump($sheet->groupCols(1, 2, false)); // Group cols 1-2, not collapsed
var_dump($sheet->groupCols(4, 5, true));  // Group cols 4-5, collapsed

// Test namedRangeSize() - should be 0 initially
var_dump($sheet->namedRangeSize());

// Test setNamedRange() - params: name, row, to_row, col, to_col
var_dump($sheet->setNamedRange('TestRange1', 0, 5, 0, 5)); // row 0-5, col 0-5
var_dump($sheet->setNamedRange('TestRange2', 2, 8, 2, 3)); // row 2-8, col 2-3

// Test namedRangeSize() - should be 2 now
var_dump($sheet->namedRangeSize());

// Test getNamedRange()
$range1 = $sheet->getNamedRange('TestRange1');
var_dump(is_array($range1));
var_dump($range1['row_first']);
var_dump($range1['row_last']);
var_dump($range1['col_first']);
var_dump($range1['col_last']);

// Test getNamedRange() with non-existent name
$nonExistent = $sheet->getNamedRange('NonExistentRange');
var_dump($nonExistent);

// Test getIndexRange()
$rangeByIndex = $sheet->getIndexRange(0);
var_dump(is_array($rangeByIndex));
var_dump(isset($rangeByIndex['row_first']));
var_dump(isset($rangeByIndex['col_first']));
var_dump(isset($rangeByIndex['hidden']));

// Test delNamedRange()
var_dump($sheet->delNamedRange('TestRange1'));
var_dump($sheet->namedRangeSize()); // Should be 1 now

// Test setNamedRange with scope - params: name, row, to_row, col, to_col, scope
var_dump($sheet->setNamedRange('ScopedRange', 0, 2, 0, 2, ExcelBook::SCOPE_WORKBOOK));
var_dump($sheet->namedRangeSize()); // Should be 2

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(false)
bool(true)
bool(true)
bool(true)
bool(true)
bool(false)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(0)
bool(true)
bool(true)
int(2)
bool(true)
int(0)
int(5)
int(0)
int(5)
bool(false)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(1)
bool(true)
int(2)
OK
