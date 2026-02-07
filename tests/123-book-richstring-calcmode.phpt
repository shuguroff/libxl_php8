--TEST--
ExcelBook: addRichString(), calcMode(), setCalcMode()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'addRichString')) die('skip ExcelBook::addRichString() not available (LibXL < 3.9.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// addRichString()
$rs = $book->addRichString();
var_dump($rs instanceof ExcelRichString);

// calcMode() default
$mode = $book->calcMode();
var_dump(is_int($mode));

// setCalcMode() / calcMode()
$book->setCalcMode(ExcelBook::CALCMODE_MANUAL);
var_dump($book->calcMode() === ExcelBook::CALCMODE_MANUAL);

$book->setCalcMode(ExcelBook::CALCMODE_AUTO);
var_dump($book->calcMode() === ExcelBook::CALCMODE_AUTO);

$book->setCalcMode(ExcelBook::CALCMODE_AUTONOTABLE);
var_dump($book->calcMode() === ExcelBook::CALCMODE_AUTONOTABLE);

// Constants values
var_dump(ExcelBook::CALCMODE_MANUAL === 0);
var_dump(ExcelBook::CALCMODE_AUTO === 1);
var_dump(ExcelBook::CALCMODE_AUTONOTABLE === 2);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
