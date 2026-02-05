--TEST--
ExcelSheet print fit methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('PrintFit Test');

// Write some data
for ($i = 0; $i < 50; $i++) {
    for ($j = 0; $j < 20; $j++) {
        $sheet->write($i, $j, "Data $i,$j");
    }
}

// Test getPrintFit() - default values (returns false when not set)
$printFit = $sheet->getPrintFit();
var_dump($printFit === false || is_array($printFit));

// Set print fit first
var_dump($sheet->setPrintFit(1, 2));

// Now getPrintFit should return array
$printFit = $sheet->getPrintFit();
var_dump(is_array($printFit));
var_dump($printFit['width']);
var_dump($printFit['height']);

// Test setPrintFit() with different values
var_dump($sheet->setPrintFit(2, 3));
$printFit = $sheet->getPrintFit();
var_dump($printFit['width']);
var_dump($printFit['height']);

// Test setPrintFit() to fit on one page
var_dump($sheet->setPrintFit(1, 1));
$printFit = $sheet->getPrintFit();
var_dump($printFit['width']);
var_dump($printFit['height']);

// Test setPrintFit() with 0 (clears/disables fit to page)
var_dump($sheet->setPrintFit(0, 0));
$printFit = $sheet->getPrintFit();
// After setting 0,0 getPrintFit may return false or array with 0,0
var_dump($printFit === false || (is_array($printFit) && $printFit['width'] == 0));

// Test related print settings
$sheet->setPrintRepeatRows(0, 2);
$sheet->setPrintRepeatCols(0, 1);
$sheet->setPrintArea(0, 49, 0, 19);

// Test printRepeatRows()
$repeatRows = $sheet->printRepeatRows();
var_dump(is_array($repeatRows));
var_dump($repeatRows['row_start']);
var_dump($repeatRows['row_end']);

// Test printRepeatCols()
$repeatCols = $sheet->printRepeatCols();
var_dump(is_array($repeatCols));
var_dump($repeatCols['col_start']);
var_dump($repeatCols['col_end']);

// Test printArea()
$printArea = $sheet->printArea();
var_dump(is_array($printArea));
var_dump($printArea['row_start']);
var_dump($printArea['row_end']);
var_dump($printArea['col_start']);
var_dump($printArea['col_end']);

// Test clearPrintRepeats()
var_dump($sheet->clearPrintRepeats());
var_dump($sheet->printRepeatRows()); // Should return false
var_dump($sheet->printRepeatCols()); // Should return false

// Test clearPrintArea()
var_dump($sheet->clearPrintArea());
var_dump($sheet->printArea()); // Should return false

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
int(1)
int(2)
bool(true)
int(2)
int(3)
bool(true)
int(1)
int(1)
bool(true)
bool(true)
bool(true)
int(0)
int(2)
bool(true)
int(0)
int(1)
bool(true)
int(0)
int(0)
int(49)
int(19)
bool(true)
bool(false)
bool(false)
bool(true)
bool(false)
OK
