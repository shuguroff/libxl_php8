--TEST--
ExcelBook/ExcelSheet: conditionalFormat/Formatting size and access (v5.1.0)
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelBook', 'conditionalFormatSize')) die('skip ExcelBook::conditionalFormatSize() not available (LibXL < 5.1.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Sheet1');

// Initially no conditional formats/formattings
var_dump($book->conditionalFormatSize());

// Add a conditional format and formatting
$cf = $book->addConditionalFormat();
var_dump($cf instanceof ExcelConditionalFormat);

$cftg = $sheet->addConditionalFormatting(1, 5, 0, 3);
var_dump($cftg instanceof ExcelConditionalFormatting);

// Add a rule so the formatting is saved
$cftg->addRule(ExcelConditionalFormatting::CFORMAT_CONTAINSTEXT, $cf, '=A2="test"');

// Save and reload to verify persistence
$file = tempnam(sys_get_temp_dir(), 'libxl') . '.xlsx';
$book->save($file);

$book2 = new ExcelBook(null, null, true);
$book2->loadFile($file);
$sheet2 = $book2->getSheet(0);

// Check conditionalFormatSize on book
$cfSize = $book2->conditionalFormatSize();
var_dump($cfSize >= 1);

// Get conditional format by index
if ($cfSize > 0) {
    $cf2 = $book2->conditionalFormat(0);
    var_dump($cf2 instanceof ExcelConditionalFormat);
} else {
    var_dump(true);
}

// Check conditionalFormattingSize on sheet
$cftgSize = $sheet2->conditionalFormattingSize();
var_dump($cftgSize >= 1);

// Get conditional formatting by index
if ($cftgSize > 0) {
    $cftg2 = $sheet2->conditionalFormatting(0);
    var_dump($cftg2 instanceof ExcelConditionalFormatting);

    // Remove it
    $removed = $sheet2->removeConditionalFormatting(0);
    var_dump($removed);

    // Size should decrease
    var_dump($sheet2->conditionalFormattingSize() < $cftgSize);
} else {
    var_dump(true);
    var_dump(true);
    var_dump(true);
}

unlink($file);
echo "OK\n";
?>
--CLEAN--
<?php @unlink($file); ?>
--EXPECT--
int(0)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
