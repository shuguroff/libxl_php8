--TEST--
ExcelSheet::addTable, tableSize, getTableByName, getTableByIndex, ExcelTable name/ref/style
--SKIPIF--
<?php if (!extension_loaded("excel")) die("skip excel ext missing"); if (!class_exists('ExcelTable')) die('skip LibXL < 4.6.0'); ?>
--FILE--
<?php

$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet("Sheet1");

// write data starting from row 1 (row 0 reserved for trial watermark)
$sheet->write(1, 0, "Name");
$sheet->write(1, 1, "Value");
$sheet->write(2, 0, "Alice");
$sheet->write(2, 1, 100);
$sheet->write(3, 0, "Bob");
$sheet->write(3, 1, 200);

// addTable
$table = $sheet->addTable("TestTable", 1, 3, 0, 1, true, ExcelTable::TABLESTYLE_LIGHT5);
var_dump($table instanceof ExcelTable);

// name
var_dump($table->name());

// ref
$ref = $table->ref();
var_dump(is_string($ref) && strlen($ref) > 0);

// style
var_dump($table->style() === ExcelTable::TABLESTYLE_LIGHT5);

// setStyle
$table->setStyle(ExcelTable::TABLESTYLE_DARK3);
var_dump($table->style() === ExcelTable::TABLESTYLE_DARK3);

// setName
$table->setName("RenamedTable");
var_dump($table->name());

// tableSize
var_dump($sheet->tableSize());

// save and reload to find tables
$file = tempnam(sys_get_temp_dir(), 'libxl') . '.xlsx';
$book->save($file);

$book2 = new ExcelBook(null, null, true);
$book2->loadFile($file);
$sheet2 = $book2->getSheet(0);

// getTableByIndex
$t2 = $sheet2->getTableByIndex(0);
var_dump($t2 instanceof ExcelTable);
var_dump($t2->name());

// getTableByName
$t3 = $sheet2->getTableByName("RenamedTable");
var_dump($t3 instanceof ExcelTable);

// getTableByName with wrong name
$t4 = $sheet2->getTableByName("NoSuchTable");
var_dump($t4);

@unlink($file);
echo "OK\n";
?>
--EXPECT--
bool(true)
string(9) "TestTable"
bool(true)
bool(true)
bool(true)
string(12) "RenamedTable"
int(1)
bool(true)
string(12) "RenamedTable"
bool(true)
bool(false)
OK
