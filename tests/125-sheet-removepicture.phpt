--TEST--
ExcelSheet: removePicture(), removePictureByIndex()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'removePicture')) die('skip ExcelSheet::removePicture() not available (LibXL < 3.9.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// removePicture() on cell with no picture
$result = $sheet->removePicture(0, 0);
var_dump(is_bool($result));

// removePictureByIndex() with invalid index
$result2 = $sheet->removePictureByIndex(999);
var_dump(is_bool($result2));

// Verify methods exist and are callable
var_dump(method_exists($sheet, 'removePicture'));
var_dump(method_exists($sheet, 'removePictureByIndex'));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
OK
