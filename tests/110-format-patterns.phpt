--TEST--
ExcelFormat pattern colors methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Pattern Colors Test');

$format = $book->addFormat();

// Test default patternForegroundColor()
var_dump($format->patternForegroundColor());

// Test default patternBackgroundColor()
var_dump($format->patternBackgroundColor());

// Set fill pattern first (required for colors to be visible)
$format->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
var_dump($format->fillPattern());

// Test patternForegroundColor() - set and get
var_dump($format->patternForegroundColor(ExcelFormat::COLOR_RED));
var_dump($format->patternForegroundColor());

// Test patternBackgroundColor() - set and get
var_dump($format->patternBackgroundColor(ExcelFormat::COLOR_YELLOW));
var_dump($format->patternBackgroundColor());

// Apply format to cell
$sheet->write(0, 0, 'Solid Red', $format);

// Create format with different pattern
$format2 = $book->addFormat();
$format2->fillPattern(ExcelFormat::FILLPATTERN_GRAY50);
$format2->patternForegroundColor(ExcelFormat::COLOR_BLUE);
$format2->patternBackgroundColor(ExcelFormat::COLOR_WHITE);

var_dump($format2->fillPattern());
var_dump($format2->patternForegroundColor());
var_dump($format2->patternBackgroundColor());

$sheet->write(1, 0, 'Gray50 Blue/White', $format2);

// Test with various patterns
$patterns = [
    ExcelFormat::FILLPATTERN_HORSTRIPE,
    ExcelFormat::FILLPATTERN_VERSTRIPE,
    ExcelFormat::FILLPATTERN_DIAGSTRIPE,
    ExcelFormat::FILLPATTERN_DIAGCROSSHATCH,
];

$row = 2;
foreach ($patterns as $pattern) {
    $fmt = $book->addFormat();
    $fmt->fillPattern($pattern);
    $fmt->patternForegroundColor(ExcelFormat::COLOR_GREEN);
    $fmt->patternBackgroundColor(ExcelFormat::COLOR_LIGHTYELLOW);

    var_dump($fmt->fillPattern());

    $sheet->write($row++, 0, "Pattern $pattern", $fmt);
}

// Test all FILLPATTERN constants exist
var_dump(ExcelFormat::FILLPATTERN_NONE);
var_dump(ExcelFormat::FILLPATTERN_SOLID);
var_dump(ExcelFormat::FILLPATTERN_GRAY50);
var_dump(ExcelFormat::FILLPATTERN_GRAY75);
var_dump(ExcelFormat::FILLPATTERN_GRAY25);
var_dump(ExcelFormat::FILLPATTERN_HORSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_VERSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_REVDIAGSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_DIAGSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_DIAGCROSSHATCH);
var_dump(ExcelFormat::FILLPATTERN_THICKDIAGCROSSHATCH);
var_dump(ExcelFormat::FILLPATTERN_THINHORSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_THINVERSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_THINREVDIAGSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_THINDIAGSTRIPE);
var_dump(ExcelFormat::FILLPATTERN_THINHORCROSSHATCH);
var_dump(ExcelFormat::FILLPATTERN_THINDIAGCROSSHATCH);
var_dump(ExcelFormat::FILLPATTERN_GRAY12P5);
var_dump(ExcelFormat::FILLPATTERN_GRAY6P25);

// Test some COLOR constants
var_dump(ExcelFormat::COLOR_BLACK);
var_dump(ExcelFormat::COLOR_WHITE);
var_dump(ExcelFormat::COLOR_RED);
var_dump(ExcelFormat::COLOR_GREEN);
var_dump(ExcelFormat::COLOR_BLUE);
var_dump(ExcelFormat::COLOR_YELLOW);
var_dump(ExcelFormat::COLOR_DEFAULT_FOREGROUND);
var_dump(ExcelFormat::COLOR_DEFAULT_BACKGROUND);

echo "OK\n";
?>
--EXPECT--
int(64)
int(65)
int(1)
int(10)
int(10)
int(13)
int(13)
int(2)
int(12)
int(9)
int(5)
int(6)
int(8)
int(9)
int(0)
int(1)
int(2)
int(3)
int(4)
int(5)
int(6)
int(7)
int(8)
int(9)
int(10)
int(11)
int(12)
int(13)
int(14)
int(15)
int(16)
int(17)
int(18)
int(8)
int(9)
int(10)
int(17)
int(12)
int(13)
int(64)
int(65)
OK
