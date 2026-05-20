--TEST--
ExcelBook::loadWithoutEmptyCells() loads xlsx files
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x05020000) die('skip LibXL 5.2.0+ required');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Sparse');
$sheet->write(0, 0, 'Hello');
$sheet->write(5, 5, 'World');

$file = tempnam(sys_get_temp_dir(), 'libxl_sparse_') . '.xlsx';
var_dump($book->save($file));

$book2 = new ExcelBook(null, null, true);
var_dump($book2->loadWithoutEmptyCells($file));
$sheet2 = $book2->getSheet(0);

var_dump($sheet2 instanceof ExcelSheet);
var_dump($sheet2->read(0, 0));
var_dump($sheet2->read(5, 5));

@unlink($file);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
string(5) "Hello"
string(5) "World"
OK
