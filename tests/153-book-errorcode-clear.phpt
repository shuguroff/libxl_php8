--TEST--
ExcelBook: errorCode, clear, and ErrorCode constants
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'errorCode')) die('skip ExcelBook::errorCode() not available (LibXL < 5.1.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX

// After creating a fresh book, errorCode should be OK
var_dump($book->errorCode() === ExcelBook::ERRCODE_OK);

// Verify some constants
var_dump(ExcelBook::ERRCODE_OK === 0);
var_dump(ExcelBook::ERRCODE_INCORRECTPASSWORD === 1);
var_dump(ExcelBook::ERRCODE_ROWOUTOFRANGE === 2);
var_dump(ExcelBook::ERRCODE_COLOUTOFRANGE === 3);
var_dump(ExcelBook::ERRCODE_TRIALLIMIT === 84);

// Add a sheet and write data
$sheet = $book->addSheet('Test');
$sheet->write(1, 0, 'hello');
var_dump($book->sheetCount());

// clear() resets the book
$book->clear();
var_dump($book->sheetCount());

// Verify clear and errorCode methods exist
var_dump(method_exists($book, 'errorCode'));
var_dump(method_exists($book, 'clear'));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(1)
int(0)
bool(true)
bool(true)
OK
