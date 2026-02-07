--TEST--
ExcelTable::showRowStripes, showColumnStripes, showFirstColumn, showLastColumn
--SKIPIF--
<?php if (!extension_loaded("excel")) die("skip excel ext missing"); if (!class_exists('ExcelTable')) die('skip LibXL < 4.6.0'); ?>
--FILE--
<?php

$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet("Sheet1");

// row 0 reserved for trial watermark
$sheet->write(1, 0, "A");
$sheet->write(1, 1, "B");
$sheet->write(2, 0, 1);
$sheet->write(2, 1, 2);

$table = $sheet->addTable("T1", 1, 2, 0, 1, true);

// defaults
var_dump($table->showRowStripes());
var_dump($table->showColumnStripes());
var_dump($table->showFirstColumn());
var_dump($table->showLastColumn());

// toggle all
$table->setShowRowStripes(false);
$table->setShowColumnStripes(true);
$table->setShowFirstColumn(true);
$table->setShowLastColumn(true);

var_dump($table->showRowStripes());
var_dump($table->showColumnStripes());
var_dump($table->showFirstColumn());
var_dump($table->showLastColumn());

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
bool(true)
bool(true)
OK
