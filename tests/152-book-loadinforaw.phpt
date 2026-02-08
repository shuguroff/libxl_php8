--TEST--
ExcelBook: loadInfoRaw
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'loadInfoRaw')) die('skip ExcelBook::loadInfoRaw() not available (LibXL < 5.0.1)');
?>
--FILE--
<?php
// Create a workbook with known sheets
$book = new ExcelBook(null, null, true); // XLSX
$book->addSheet('Alpha');
$book->addSheet('Beta');
$sheet = $book->getSheet(0);
$sheet->write(1, 0, 'data');

$file = tempnam(sys_get_temp_dir(), 'libxl') . '.xlsx';
$book->save($file);

// Read raw data from file
$data = file_get_contents($file);
unlink($file);

// loadInfoRaw should succeed
$book2 = new ExcelBook(null, null, true);
$result = $book2->loadInfoRaw($data);
var_dump($result);

// After loadInfoRaw, sheet count should be available
var_dump($book2->sheetCount() === 2);

// Verify method exists
var_dump(method_exists($book2, 'loadInfoRaw'));

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
OK
