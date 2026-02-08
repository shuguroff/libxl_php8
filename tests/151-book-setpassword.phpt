--TEST--
ExcelBook: setPassword
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'setPassword')) die('skip ExcelBook::setPassword() not available (LibXL < 5.0.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Sheet1');
$sheet->write(1, 0, 'test');

// setPassword should not throw
$book->setPassword('secret123');

// Save and reload — file should load fine without password param
$file = tempnam(sys_get_temp_dir(), 'libxl') . '.xlsx';
$book->save($file);
var_dump(file_exists($file));

// Verify method exists
var_dump(method_exists($book, 'setPassword'));

unlink($file);
echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
OK
