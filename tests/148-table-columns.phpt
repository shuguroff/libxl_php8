--TEST--
ExcelTable::columnSize, columnName, setColumnName
--SKIPIF--
<?php if (!extension_loaded("excel")) die("skip excel ext missing"); if (!class_exists('ExcelTable')) die('skip LibXL < 4.6.0'); ?>
--FILE--
<?php

$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet("Sheet1");

// row 0 reserved for trial watermark
$sheet->write(1, 0, "Col1");
$sheet->write(1, 1, "Col2");
$sheet->write(1, 2, "Col3");
$sheet->write(2, 0, 10);
$sheet->write(2, 1, 20);
$sheet->write(2, 2, 30);

$table = $sheet->addTable("T1", 1, 2, 0, 2, true);

// columnSize
var_dump($table->columnSize());

// columnName
var_dump($table->columnName(0));
var_dump($table->columnName(1));
var_dump($table->columnName(2));

// columnName out of range
var_dump($table->columnName(99));

// setColumnName
var_dump($table->setColumnName(1, "NewCol2"));
var_dump($table->columnName(1));

echo "OK\n";
?>
--EXPECT--
int(3)
string(4) "Col1"
string(4) "Col2"
string(4) "Col3"
bool(false)
bool(true)
string(7) "NewCol2"
OK
