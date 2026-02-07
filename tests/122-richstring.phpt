--TEST--
ExcelRichString class: addFont(), addText(), getText(), textSize()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelRichString')) die('skip ExcelRichString not available (LibXL < 3.9.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// Create a rich string
$rs = $book->addRichString();
var_dump($rs instanceof ExcelRichString);

// textSize() on empty rich string
var_dump($rs->textSize() === 0);

// addFont() returns ExcelFont
$font1 = $rs->addFont();
var_dump($font1 instanceof ExcelFont);

// addText() returns true
$result = $rs->addText("Hello ");
var_dump($result === true);

// addFont() with init font
$font2 = $rs->addFont($font1);
var_dump($font2 instanceof ExcelFont);

// addText() with font
$result2 = $rs->addText("World", $font2);
var_dump($result2 === true);

// textSize() should be 2
var_dump($rs->textSize() === 2);

// getText(0)
$seg0 = $rs->getText(0);
var_dump(is_array($seg0));
var_dump($seg0['text'] === 'Hello ');

// getText(1)
$seg1 = $rs->getText(1);
var_dump(is_array($seg1));
var_dump($seg1['text'] === 'World');
var_dump($seg1['font'] instanceof ExcelFont);

// addFont() with null
$font3 = $rs->addFont(null);
var_dump($font3 instanceof ExcelFont);

// ExcelRichString cannot be instantiated directly
try {
    $rs2 = new ExcelRichString();
    echo "ERROR: should have thrown\n";
} catch (ExcelException $e) {
    var_dump(true);
}

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
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
