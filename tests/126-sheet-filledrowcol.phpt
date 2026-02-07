--TEST--
ExcelSheet::firstFilledRow/lastFilledRow/firstFilledCol/lastFilledCol
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'firstFilledRow')) die('skip LibXL < 3.9.1');
?>
--FILE--
<?php
// Test with XLSX
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// Empty sheet — boundaries should be valid ints
var_dump(is_int($sheet->firstFilledRow()));
var_dump(is_int($sheet->lastFilledRow()));
var_dump(is_int($sheet->firstFilledCol()));
var_dump(is_int($sheet->lastFilledCol()));

// Write data at specific positions
$sheet->write(2, 3, 'hello');
$sheet->write(5, 7, 'world');

// Save and reload to ensure filled boundaries are calculated
$file = tempnam(sys_get_temp_dir(), 'libxl') . '.xlsx';
$book->save($file);

$book2 = new ExcelBook(null, null, true);
$book2->loadFile($file);
$sheet2 = $book2->getSheet(0);

$firstRow = $sheet2->firstFilledRow();
$lastRow = $sheet2->lastFilledRow();
$firstCol = $sheet2->firstFilledCol();
$lastCol = $sheet2->lastFilledCol();

var_dump($firstRow); // 2
var_dump($lastRow);  // 6 (one past last)
var_dump($firstCol); // 3
var_dump($lastCol);  // 8 (one past last)

// Compare with firstRow/lastRow/firstCol/lastCol
var_dump($firstRow === $sheet2->firstRow());
var_dump($lastRow === $sheet2->lastRow());
var_dump($firstCol === $sheet2->firstCol());
var_dump($lastCol === $sheet2->lastCol());

unlink($file);
echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
int(2)
int(6)
int(3)
int(8)
bool(true)
bool(true)
bool(true)
bool(true)
OK
