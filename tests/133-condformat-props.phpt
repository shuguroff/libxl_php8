--TEST--
ExcelConditionalFormat: border, fill and numFormat properties
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelConditionalFormat')) die('skip ExcelConditionalFormat not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true); // XLSX
$cf = $book->addConditionalFormat();
var_dump($cf instanceof ExcelConditionalFormat);

// Test numFormat
$cf->setNumFormat(1);
var_dump($cf->numFormat());

// Test customNumFormat
$cf->setCustomNumFormat('#,##0.00');
var_dump($cf->customNumFormat());

// Test font
$font = $cf->font();
var_dump($font instanceof ExcelFont);

// Test border styles
$cf->setBorder(1);
$cf->setBorderColor(8); // COLOR_BLACK

$cf->setBorderLeft(2);
var_dump($cf->borderLeft());

$cf->setBorderRight(3);
var_dump($cf->borderRight());

$cf->setBorderTop(4);
var_dump($cf->borderTop());

$cf->setBorderBottom(5);
var_dump($cf->borderBottom());

// Test border colors
$cf->setBorderLeftColor(10);
var_dump($cf->borderLeftColor());

$cf->setBorderRightColor(11);
var_dump($cf->borderRightColor());

$cf->setBorderTopColor(12);
var_dump($cf->borderTopColor());

$cf->setBorderBottomColor(13);
var_dump($cf->borderBottomColor());

// Test fill pattern
$cf->setFillPattern(1);
var_dump($cf->fillPattern());

$cf->setPatternForegroundColor(10);
var_dump($cf->patternForegroundColor());

$cf->setPatternBackgroundColor(11);
var_dump($cf->patternBackgroundColor());

echo "OK\n";
?>
--EXPECT--
bool(true)
int(1)
string(8) "#,##0.00"
bool(true)
int(2)
int(3)
int(4)
int(5)
int(10)
int(11)
int(12)
int(13)
int(1)
int(10)
int(11)
OK
