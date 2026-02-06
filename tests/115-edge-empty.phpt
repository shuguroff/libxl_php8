--TEST--
Empty values and NULL handling edge cases
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// Test empty book (no sheets)
var_dump($book->sheetCount());

// Add sheet
$sheet = $book->addSheet('Empty Test');
var_dump($book->sheetCount());

// Test empty sheet ranges
var_dump($sheet->firstRow());
var_dump($sheet->lastRow());
var_dump($sheet->firstCol());
var_dump($sheet->lastCol());

// Test reading from empty cell
$emptyRead = $sheet->read(0, 0);
var_dump($emptyRead === null || $emptyRead === '' || $emptyRead === false);

// Test cellType on empty cell
var_dump($sheet->cellType(0, 0) === ExcelSheet::CELLTYPE_EMPTY);

// Test writing NULL
$sheet->write(0, 0, null);
$nullRead = $sheet->read(0, 0);
var_dump($nullRead === null || $nullRead === '' || $nullRead === false);

// Test writing empty string
$sheet->write(1, 0, '');
$emptyString = $sheet->read(1, 0);
var_dump($emptyString === '');

// Test cellType for blank/empty cells
$type1 = $sheet->cellType(0, 0);
$type2 = $sheet->cellType(1, 0);
var_dump($type1 === ExcelSheet::CELLTYPE_EMPTY || $type1 === ExcelSheet::CELLTYPE_BLANK);
var_dump($type2 === ExcelSheet::CELLTYPE_STRING || $type2 === ExcelSheet::CELLTYPE_BLANK);

// Test writeRow with empty array
$result = $sheet->writeRow(5, []);
var_dump($result);

// Test writeRow with array containing nulls
$result = $sheet->writeRow(6, [null, null, null]);
var_dump($result);
var_dump($sheet->read(6, 0) === null || $sheet->read(6, 0) === '' || $sheet->read(6, 0) === false);

// Test writeRow with mixed data including empty
$result = $sheet->writeRow(7, ['A', '', null, 0, false]);
var_dump($result);
var_dump($sheet->read(7, 0));
var_dump($sheet->read(7, 1));
var_dump($sheet->read(7, 3) === 0.0 || $sheet->read(7, 3) === 0);
var_dump($sheet->read(7, 4) === false || $sheet->read(7, 4) === 0);

// Test writeCol with empty array
$result = $sheet->writeCol(5, []);
var_dump($result);

// Test writeCol with nulls
$result = $sheet->writeCol(6, [null, '', null]);
var_dump($result);

// Test readRow on empty row (may throw for invalid row)
try {
	$emptyRow = $sheet->readRow(100);
	var_dump(is_array($emptyRow) || $emptyRow === false);
} catch (ExcelException $e) {
	echo "EXCEPTION: " . $e->getMessage() . "\n";
	var_dump(false);
}

// Test readCol on empty column (may throw for invalid column)
try {
	$emptyCol = $sheet->readCol(100);
	var_dump(is_array($emptyCol) || $emptyCol === false);
} catch (ExcelException $e) {
	echo "EXCEPTION: " . $e->getMessage() . "\n";
	var_dump(false);
}

// Test mergeSize on sheet with no merges
var_dump($sheet->mergeSize());

// Test hyperlinkSize on sheet with no hyperlinks
var_dump($sheet->hyperlinkSize());

// Test namedRangeSize on sheet with no named ranges
var_dump($sheet->namedRangeSize());

// Test getNumPictures on sheet with no pictures
var_dump($sheet->getNumPictures());

// Test getHorPageBreakSize on sheet with no page breaks
var_dump($sheet->getHorPageBreakSize());

// Test getVerPageBreakSize on sheet with no page breaks
var_dump($sheet->getVerPageBreakSize());

// Test printRepeatRows when not set
var_dump($sheet->printRepeatRows());

// Test printRepeatCols when not set
var_dump($sheet->printRepeatCols());

// Test printArea when not set
var_dump($sheet->printArea());

// Test default header (empty) - may return null, empty string, or false
$header = $sheet->header();
var_dump($header === '' || $header === false || $header === null);

// Test default footer (empty) - may return null, empty string, or false
$footer = $sheet->footer();
var_dump($footer === '' || $footer === false || $footer === null);

// Test readComment on cell without comment
$comment = $sheet->readComment(0, 0);
var_dump($comment === '' || $comment === null || $comment === false);

// Test isFormula on non-formula cell
var_dump($sheet->isFormula(0, 0));

// Test isDate on non-date cell
var_dump($sheet->isDate(0, 0));

// Test getError on book with no error
$book2 = new ExcelBook(null, null, true);
$book2->addSheet('Test');
var_dump($book2->getError());

// Test CELLTYPE constants
var_dump(ExcelSheet::CELLTYPE_EMPTY);
var_dump(ExcelSheet::CELLTYPE_NUMBER);
var_dump(ExcelSheet::CELLTYPE_STRING);
var_dump(ExcelSheet::CELLTYPE_BOOLEAN);
var_dump(ExcelSheet::CELLTYPE_BLANK);
var_dump(ExcelSheet::CELLTYPE_ERROR);

echo "OK\n";
?>
--EXPECT--
int(0)
int(1)
int(0)
int(0)
int(0)
int(0)
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
string(1) "A"
string(0) ""
bool(true)
bool(true)
bool(true)
bool(true)
EXCEPTION: Invalid row number '100'
bool(false)
EXCEPTION: Invalid column number '100'
bool(false)
int(0)
int(0)
int(0)
int(0)
int(0)
int(0)
bool(false)
bool(false)
bool(false)
bool(true)
bool(true)
bool(true)
bool(false)
bool(false)
bool(false)
int(0)
int(1)
int(2)
int(3)
int(4)
int(5)
OK
