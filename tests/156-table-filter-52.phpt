--TEST--
ExcelTable::isAutoFilter() and removeFilter()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelTable', 'removeFilter')) die('skip ExcelTable::removeFilter() not available (LibXL < 5.2.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('TableFilter');

$sheet->write(0, 0, 'Name');
$sheet->write(0, 1, 'Score');
$sheet->write(1, 0, 'Alice');
$sheet->write(1, 1, 90);
$sheet->write(2, 0, 'Bob');
$sheet->write(2, 1, 75);

$table = $sheet->addTable('Scores', 0, 2, 0, 1, true);
var_dump($table instanceof ExcelTable);
var_dump($table->isAutoFilter());

$af = $table->autoFilter();
var_dump($af instanceof ExcelAutoFilter);

$table->removeFilter();
var_dump($table->isAutoFilter());

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(false)
OK
