--TEST--
ExcelCoreProperties: double properties (createdAsDouble, modifiedAsDouble)
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelCoreProperties')) die('skip ExcelCoreProperties not available (LibXL < 4.5.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

$cp = $book->coreProperties();

// Set created/modified as double (Excel serial date)
$cp->setCreatedAsDouble(44927.5);
var_dump($cp->createdAsDouble());

$cp->setModifiedAsDouble(44928.75);
var_dump($cp->modifiedAsDouble());

// Set as string
$cp->setCreated('2024-01-15T12:00:00Z');
var_dump(is_string($cp->created()));

$cp->setModified('2024-01-16T18:00:00Z');
var_dump(is_string($cp->modified()));

// Verify methods
var_dump(method_exists($cp, 'createdAsDouble'));
var_dump(method_exists($cp, 'setCreatedAsDouble'));
var_dump(method_exists($cp, 'modifiedAsDouble'));
var_dump(method_exists($cp, 'setModifiedAsDouble'));

echo "OK\n";
?>
--EXPECT--
float(44927.5)
float(44928.75)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
