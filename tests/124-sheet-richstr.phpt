--TEST--
ExcelSheet: isRichStr(), readRichStr(), writeRichStr()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'isRichStr')) die('skip ExcelSheet::isRichStr() not available (LibXL < 3.9.0)');
?>
--FILE--
<?php
// Trial version writes watermark in row 0, so start from row 1
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// Write a plain string first (row 1 to avoid trial watermark)
$sheet->write(1, 0, "plain text");

// isRichStr() on plain string cell
var_dump($sheet->isRichStr(1, 0) === false);

// Create and write a rich string
$rs = $book->addRichString();
$font = $rs->addFont();
$rs->addText("Bold", $font);
$rs->addText(" and normal");
$sheet->writeRichStr(2, 0, $rs);

// isRichStr() on rich string cell
var_dump($sheet->isRichStr(2, 0) === true);

// readRichStr()
$rsRead = $sheet->readRichStr(2, 0);
var_dump($rsRead instanceof ExcelRichString);
var_dump($rsRead->textSize() === 2);

$seg0 = $rsRead->getText(0);
var_dump($seg0['text'] === 'Bold');
$seg1 = $rsRead->getText(1);
var_dump($seg1['text'] === ' and normal');

// writeRichStr() with format
$format = $book->addFormat();
$rs2 = $book->addRichString();
$rs2->addText("formatted");
var_dump($sheet->writeRichStr(3, 0, $rs2, $format));

// readRichStr() on empty cell returns false
$result = $sheet->readRichStr(99, 99);
var_dump($result === false);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
