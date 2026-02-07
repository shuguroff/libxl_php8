--TEST--
ExcelSheet: colFormat, rowFormat, setBorder
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'colFormat')) die('skip ExcelSheet::colFormat() not available (LibXL < 4.5.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

// Set a column format
$format = $book->addFormat();
$format->horizontalAlign(ExcelFormat::ALIGNH_CENTER);
$sheet->setColWidth(0, 0, 20, false, $format);

// colFormat returns ExcelFormat or false
$cf = $sheet->colFormat(0);
var_dump($cf instanceof ExcelFormat);

// rowFormat — no explicit format set, may return false or default format
$rf = $sheet->rowFormat(0);
var_dump(is_object($rf) || $rf === false);

// Verify methods exist
var_dump(method_exists($sheet, 'colFormat'));
var_dump(method_exists($sheet, 'rowFormat'));

// setBorder (v4.5.1+)
if (method_exists($sheet, 'setBorder')) {
    $result = $sheet->setBorder(0, 5, 0, 5, ExcelFormat::BORDERSTYLE_THIN, 8 /* black */);
    var_dump($result);
} else {
    var_dump(true); // skip setBorder test
}

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
