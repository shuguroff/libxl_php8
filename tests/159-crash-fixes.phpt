--TEST--
Crash fixes: empty picture file, non-object format args, cellFormat book handle, getError
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Sheet1');

// addPictureFromFile on an empty file returns false, must not crash
$tmp = dirname(__FILE__) . '/159_empty.tmp';
touch($tmp);
var_dump($book->addPictureFromFile($tmp));
unlink($tmp);

// non-object format argument must not crash (TypeError on PHP 8, warning+false on PHP 7.4)
try { @$sheet->setColWidth(0, 0, 10, false, 123); } catch (Throwable $e) {}
try { @$sheet->setRowHeight(0, 15, 123); } catch (Throwable $e) {}
echo "no crash\n";

// explicit null format accepted by write and writeRow alike
var_dump($sheet->write(0, 0, 'hello', null));
var_dump($sheet->writeRow(1, array('a', 'b'), 0, null));

// cellFormat returns a format with the book handle attached: clone must work
$format = $sheet->cellFormat(0, 0);
var_dump($format instanceof ExcelFormat);
$copy = clone $format;
var_dump($copy instanceof ExcelFormat);

// read with format out-param: that format must be cloneable too
$val = $sheet->read(0, 0, $fmt);
var_dump($val);
$copy2 = clone $fmt;
var_dump($copy2 instanceof ExcelFormat);

// getError returns false when there is no error
var_dump($book->getError());
?>
--CLEAN--
<?php @unlink(dirname(__FILE__) . '/159_empty.tmp'); ?>
--EXPECT--
bool(false)
no crash
bool(true)
bool(true)
bool(true)
bool(true)
string(5) "hello"
bool(true)
bool(false)
