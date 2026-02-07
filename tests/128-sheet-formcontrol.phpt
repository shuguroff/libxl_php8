--TEST--
ExcelSheet::formControlSize() and formControl()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'formControlSize')) die('skip ExcelSheet::formControlSize() not available (LibXL < 4.0.0)');
?>
--FILE--
<?php
// On a new empty sheet, formControlSize should be 0
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

$size = $sheet->formControlSize();
var_dump($size === 0);

// formControl() with invalid index should return false
$result = $sheet->formControl(0);
var_dump($result === false);

// Verify method exists
var_dump(method_exists($sheet, 'formControlSize'));
var_dump(method_exists($sheet, 'formControl'));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
OK
