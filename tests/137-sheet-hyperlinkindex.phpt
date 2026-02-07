--TEST--
ExcelSheet: hyperlinkIndex
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'hyperlinkIndex')) die('skip ExcelSheet::hyperlinkIndex() not available (LibXL < 4.1.2)');
?>
--FILE--
<?php
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';

$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

// addHyperlink(url, row_first, row_last, col_first, col_last)
$sheet->addHyperlink('https://example.com', 1, 1, 0, 0);
$sheet->addHyperlink('https://example.org', 5, 5, 5, 5);
$book->save($tmpFile);

// Reload
$book2 = new ExcelBook(null, null, true);
$book2->loadFile($tmpFile);
$sheet2 = $book2->getSheet(0);

// No hyperlink at (0,0)
var_dump($sheet2->hyperlinkIndex(0, 0));

// Hyperlink at cell (1,0)
$idx = $sheet2->hyperlinkIndex(1, 0);
var_dump($idx >= 0);

// Hyperlink at (5,5)
$idx2 = $sheet2->hyperlinkIndex(5, 5);
var_dump($idx2 >= 0);

// No hyperlink at (10,10)
var_dump($sheet2->hyperlinkIndex(10, 10));

// Verify method exists
var_dump(method_exists($sheet2, 'hyperlinkIndex'));

@unlink($tmpFile);

echo "OK\n";
?>
--EXPECT--
int(-1)
bool(true)
bool(true)
int(-1)
bool(true)
OK
