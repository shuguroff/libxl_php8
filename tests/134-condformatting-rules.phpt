--TEST--
ExcelConditionalFormatting: addConditionalFormatting and addRule
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'addConditionalFormatting')) die('skip ExcelSheet::addConditionalFormatting() not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');

// Write some data
$sheet->write(0, 0, 10);
$sheet->write(1, 0, 20);
$sheet->write(2, 0, 30);

// Create conditional formatting
$cfing = $sheet->addConditionalFormatting(0, 2, 0, 0);
var_dump($cfing instanceof ExcelConditionalFormatting);

// Create conditional format with red background for "contains text" rule
$cf = $book->addConditionalFormat();
$cf->setPatternBackgroundColor(10); // red
$cf->setFillPattern(1);

// addRule
$cfing->addRule(
    ExcelConditionalFormatting::CFORMAT_EXPRESSION,
    $cf,
    '=A1>15'
);

// addRange
$cfing->addRange(3, 5, 0, 0);

// Create another rule with addOpNumRule
$cf2 = $book->addConditionalFormat();
$cf2->setPatternBackgroundColor(17); // green

$cfing2 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing2->addOpNumRule(
    ExcelConditionalFormatting::CFOPERATOR_BETWEEN,
    $cf2,
    10.0,
    25.0
);

// addTopRule
$cf3 = $book->addConditionalFormat();
$cfing3 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing3->addTopRule($cf3, 1);

// addAboveAverageRule
$cf4 = $book->addConditionalFormat();
$cfing4 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing4->addAboveAverageRule($cf4);

// addTimePeriodRule
$cf5 = $book->addConditionalFormat();
$cfing5 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing5->addTimePeriodRule($cf5, ExcelConditionalFormatting::CFTP_TODAY);

// add2ColorScaleRule
$cfing6 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing6->add2ColorScaleRule(
    0xFF0000, 0x00FF00,
    ExcelConditionalFormatting::CFVO_MIN, 0,
    ExcelConditionalFormatting::CFVO_MAX, 0
);

// addOpStrRule
$cf7 = $book->addConditionalFormat();
$cfing7 = $sheet->addConditionalFormatting(0, 2, 0, 0);
$cfing7->addOpStrRule(
    ExcelConditionalFormatting::CFOPERATOR_CONTAINSTEXT,
    $cf7,
    'hello',
    ''
);

// Save and verify no errors
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';
var_dump($book->save($tmpFile));

echo "OK\n";
?>
--CLEAN--
<?php
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';
@unlink($tmpFile);
?>
--EXPECT--
bool(true)
bool(true)
OK
