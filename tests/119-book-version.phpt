--TEST--
ExcelBook::version(), isWriteProtected(), loadWithoutEmptyCells()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'version')) die('skip ExcelBook::version() not available');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// version() returns an integer > 0
$ver = $book->version();
var_dump(is_int($ver));
var_dump($ver > 0);

// isWriteProtected() returns bool
$wp = $book->isWriteProtected();
var_dump(is_bool($wp));
var_dump($wp === false); // new book is not write-protected

// loadWithoutEmptyCells() with non-existing file should return false
$result = $book->loadWithoutEmptyCells('/tmp/nonexistent_' . uniqid() . '.xlsx');
var_dump($result === false);

// loadWithoutEmptyCells() with empty string should return false
$result2 = $book->loadWithoutEmptyCells('');
var_dump($result2 === false);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
