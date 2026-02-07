--TEST--
ExcelTable::autoFilter, ExcelSheet::applyFilter2
--SKIPIF--
<?php if (!extension_loaded("excel")) die("skip excel ext missing"); if (!class_exists('ExcelTable')) die('skip LibXL < 4.6.0'); ?>
--FILE--
<?php

$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet("Sheet1");

// row 0 reserved for trial watermark
$sheet->write(1, 0, "Name");
$sheet->write(1, 1, "Score");
$sheet->write(2, 0, "Alice");
$sheet->write(2, 1, 90);
$sheet->write(3, 0, "Bob");
$sheet->write(3, 1, 75);

$table = $sheet->addTable("T1", 1, 3, 0, 1, true);

// autoFilter
$af = $table->autoFilter();
var_dump($af instanceof ExcelAutoFilter);

// applyFilter2 — void, just ensure no error
$sheet->applyFilter2($af);

echo "OK\n";
?>
--EXPECT--
bool(true)
OK
