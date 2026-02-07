--TEST--
ExcelBook: removeVBA and removePrinterSettings
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'removeVBA')) die('skip ExcelBook::removeVBA() not available (LibXL < 4.3.0)');
?>
--FILE--
<?php
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';

$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');
$sheet->write(0, 0, 'hello');
$book->save($tmpFile);

// Reload and try removeVBA (no VBA present, but should not crash)
$book2 = new ExcelBook(null, null, true);
$book2->loadFile($tmpFile);

// removeVBA returns bool
$result = $book2->removeVBA();
var_dump(is_bool($result));

// removePrinterSettings returns bool
$result2 = $book2->removePrinterSettings();
var_dump(is_bool($result2));

// Verify methods exist
var_dump(method_exists($book2, 'removeVBA'));
var_dump(method_exists($book2, 'removePrinterSettings'));

@unlink($tmpFile);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
OK
