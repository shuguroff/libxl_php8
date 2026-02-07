--TEST--
ExcelBook: dpiAwareness and setDpiAwareness
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'dpiAwareness')) die('skip ExcelBook::dpiAwareness() not available (LibXL < 4.4.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX

// Get default dpiAwareness
$dpi = $book->dpiAwareness();
var_dump(is_int($dpi));

// Set dpiAwareness
$book->setDpiAwareness(1);
var_dump($book->dpiAwareness());

$book->setDpiAwareness(0);
var_dump($book->dpiAwareness());

// Verify methods
var_dump(method_exists($book, 'dpiAwareness'));
var_dump(method_exists($book, 'setDpiAwareness'));

echo "OK\n";
?>
--EXPECT--
bool(true)
int(1)
int(0)
bool(true)
bool(true)
OK
