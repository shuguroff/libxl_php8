--TEST--
ExcelCoreProperties: removeAll and constructor check
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelCoreProperties')) die('skip ExcelCoreProperties not available (LibXL < 4.5.0)');
?>
--FILE--
<?php
// Cannot instantiate directly
try {
    new ExcelCoreProperties();
    echo "FAIL: should not reach here\n";
} catch (ExcelException $e) {
    var_dump(true);
}

$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

$cp = $book->coreProperties();
$cp->setTitle('Title');
$cp->setSubject('Subject');
$cp->setCreator('Creator');

var_dump($cp->title());

// Remove all properties
$cp->removeAll();
var_dump($cp->title());

echo "OK\n";
?>
--EXPECT--
bool(true)
string(5) "Title"
string(0) ""
OK
