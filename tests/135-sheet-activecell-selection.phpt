--TEST--
ExcelSheet: getActiveCell, setActiveCell, selectionRange, addSelectionRange, removeSelection
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'getActiveCell')) die('skip ExcelSheet::getActiveCell() not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

// setActiveCell + getActiveCell
$sheet->setActiveCell(5, 3);
$active = $sheet->getActiveCell();
var_dump($active['row']);
var_dump($active['col']);

// selectionRange - initially empty or default
$range = $sheet->selectionRange();
var_dump(is_string($range));

// addSelectionRange
$sheet->addSelectionRange('A1:B5');
$range2 = $sheet->selectionRange();
var_dump(is_string($range2));

// removeSelection
$sheet->removeSelection();

// Verify methods exist
var_dump(method_exists($sheet, 'getActiveCell'));
var_dump(method_exists($sheet, 'setActiveCell'));
var_dump(method_exists($sheet, 'selectionRange'));
var_dump(method_exists($sheet, 'addSelectionRange'));
var_dump(method_exists($sheet, 'removeSelection'));

echo "OK\n";
?>
--EXPECT--
int(5)
int(3)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
