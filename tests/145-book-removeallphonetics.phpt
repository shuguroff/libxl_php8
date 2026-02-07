--TEST--
ExcelBook: removeAllPhonetics
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'removeAllPhonetics')) die('skip ExcelBook::removeAllPhonetics() not available (LibXL < 4.5.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');
$sheet->write(0, 0, 'hello');

// removeAllPhonetics returns void — should not crash
$book->removeAllPhonetics();

// Verify method exists
var_dump(method_exists($book, 'removeAllPhonetics'));
var_dump(method_exists($book, 'coreProperties'));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
OK
