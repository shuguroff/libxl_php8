--TEST--
ExcelSheet: tabColor and getTabRgbColor
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'tabColor')) die('skip ExcelSheet::tabColor() not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';

$book = new ExcelBook(null, null, true); // XLSX
$book->setRGBMode(true);
$sheet = $book->addSheet('Test');

// Set tab color using the existing setter and save
$sheet->setTabRgbColor(255, 0, 128);
$book->save($tmpFile);

// Reload and verify
$book2 = new ExcelBook(null, null, true);
$book2->setRGBMode(true);
$book2->loadFile($tmpFile);
$sheet2 = $book2->getSheet(0);

// Read back via getTabRgbColor
$rgb = $sheet2->getTabRgbColor();
var_dump($rgb['red']);
var_dump($rgb['green']);
var_dump($rgb['blue']);

// tabColor returns an int color value
$color = $sheet2->tabColor();
var_dump(is_int($color));

// Verify methods
var_dump(method_exists($sheet2, 'tabColor'));
var_dump(method_exists($sheet2, 'getTabRgbColor'));

@unlink($tmpFile);

echo "OK\n";
?>
--EXPECT--
int(255)
int(0)
int(128)
bool(true)
bool(true)
bool(true)
OK
