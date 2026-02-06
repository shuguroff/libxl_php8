--TEST--
ExcelSheet negative tests (error handling)
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('NegativeTests');

// Write some valid data first
$sheet->write(0, 0, 'Test');
$sheet->write(1, 0, 12345);

// Test read() with very large row number (may not error, returns null/false)
$result = $sheet->read(1000000, 0);
var_dump($result === null || $result === '' || $result === false);

// Test read() with very large column number
$result = $sheet->read(0, 100000);
var_dump($result === null || $result === '' || $result === false);

// Test cellType() with out-of-range coordinates
$type = $sheet->cellType(999999, 0);
var_dump($type === ExcelSheet::CELLTYPE_EMPTY || $type === ExcelSheet::CELLTYPE_BLANK);

// Test setColWidth() with invalid column range (Start > End throws ExcelException)
try {
    $sheet->setColWidth(5, 2, 10.0);
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

// Test setRowHeight() with very large row
$result = $sheet->setRowHeight(1048577, 15.0); // Excel max rows is 1048576
var_dump(is_bool($result));

// Test insertRow() with start > end
$result = $sheet->insertRow(10, 5);
var_dump(is_bool($result));

// Test insertCol() with start > end
$result = $sheet->insertCol(10, 5);
var_dump(is_bool($result));

// Test removeRow() with invalid range
$result = $sheet->removeRow(100, 50);
var_dump(is_bool($result));

// Test removeCol() with invalid range
$result = $sheet->removeCol(100, 50);
var_dump(is_bool($result));

// Test setMerge() with invalid range (start > end)
$result = $sheet->setMerge(5, 2, 5, 2);
var_dump(is_bool($result));

// Test deleteMerge() on non-merged cell
$result = $sheet->deleteMerge(50, 50);
var_dump(is_bool($result));

// Test getMerge() on non-merged cell
$merge = $sheet->getMerge(100, 100);
var_dump(is_array($merge) || $merge === false);

// Test getNamedRange() with empty name
$range = $sheet->getNamedRange('');
var_dump($range === false);

// Test delNamedRange() with non-existent name
$result = $sheet->delNamedRange('NonExistentRange');
var_dump($result === false);

// Test writeComment() with empty strings
$sheet->writeComment(10, 0, '', '', 100, 100);
var_dump(true); // Should not crash

// Test readComment() on cell without comment
$comment = $sheet->readComment(100, 100);
var_dump($comment === '' || $comment === null || $comment === false);

// Test horPageBreak() with negative row
$result = $sheet->horPageBreak(-1, true);
var_dump(is_bool($result));

// Test verPageBreak() with negative column
$result = $sheet->verPageBreak(-1, true);
var_dump(is_bool($result));

// Test setZoom() with out-of-range value
$sheet->setZoom(500); // May be clamped or ignored
var_dump($sheet->zoom() > 0);

// Test setZoomPrint() with out-of-range value
$sheet->setZoomPrint(500); // May be clamped or ignored
var_dump($sheet->zoomPrint() > 0);

// Test getHorPageBreak() with invalid index
$break = $sheet->getHorPageBreak(9999);
var_dump(is_int($break) || $break === false);

// Test getVerPageBreak() with invalid index
$break = $sheet->getVerPageBreak(9999);
var_dump(is_int($break) || $break === false);

// Test getPictureInfo() with invalid index (no pictures added)
$info = $sheet->getPictureInfo(0);
var_dump($info === false || is_array($info));

// Test delHyperlink() with invalid index
$result = $sheet->delHyperlink(9999);
var_dump(is_bool($result));

// Test hyperlink() with invalid index
$link = $sheet->hyperlink(9999);
var_dump($link === false || is_array($link));

// Test delMergeByIndex() with invalid index
$result = $sheet->delMergeByIndex(9999);
var_dump(is_bool($result));

// Test merge() with invalid index
$merge = $sheet->merge(9999);
var_dump($merge === false || is_array($merge));

// Test getIndexRange() with invalid index
$range = $sheet->getIndexRange(9999);
var_dump($range === false || is_array($range));

// Test setNamedRange() with empty name
try {
    $sheet->setNamedRange('', 0, 0, 0, 0);
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

// Test setNamedRange() with row start > row end
try {
    $sheet->setNamedRange('test', 5, 2, 0, 0);
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

// Test setRowHeight() with negative row
try {
    $sheet->setRowHeight(-1, 15.0);
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

// Test addrToRowCol() with empty reference
try {
    $sheet->addrToRowCol('');
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
ExcelException: Start cell is greater than end cell
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
ExcelException: The range name cannot be empty
ExcelException: The range row start cannot be greater than row end
ExcelException: Row number cannot be less than 0
ExcelException: Cell reference cannot be empty
OK
