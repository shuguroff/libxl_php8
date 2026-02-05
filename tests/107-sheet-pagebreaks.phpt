--TEST--
ExcelSheet page breaks methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('PageBreaks Test');

// Write some data
for ($i = 0; $i < 20; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $sheet->write($i, $j, "Cell $i,$j");
    }
}

// Test getHorPageBreakSize() - should be 0 initially
var_dump($sheet->getHorPageBreakSize());

// Test getVerPageBreakSize() - should be 0 initially
var_dump($sheet->getVerPageBreakSize());

// Test horPageBreak() - add horizontal page breaks
var_dump($sheet->horPageBreak(5, true));  // Add break after row 5
var_dump($sheet->horPageBreak(10, true)); // Add break after row 10
var_dump($sheet->horPageBreak(15, true)); // Add break after row 15

// Test getHorPageBreakSize() - should be 3 now
var_dump($sheet->getHorPageBreakSize());

// Test getHorPageBreak()
var_dump($sheet->getHorPageBreak(0));
var_dump($sheet->getHorPageBreak(1));
var_dump($sheet->getHorPageBreak(2));

// Test verPageBreak() - add vertical page breaks
var_dump($sheet->verPageBreak(3, true)); // Add break after column 3
var_dump($sheet->verPageBreak(6, true)); // Add break after column 6

// Test getVerPageBreakSize() - should be 2 now
var_dump($sheet->getVerPageBreakSize());

// Test getVerPageBreak()
var_dump($sheet->getVerPageBreak(0));
var_dump($sheet->getVerPageBreak(1));

// Test removing page breaks
var_dump($sheet->horPageBreak(5, false)); // Remove break at row 5
var_dump($sheet->getHorPageBreakSize()); // Should be 2 now

var_dump($sheet->verPageBreak(3, false)); // Remove break at column 3
var_dump($sheet->getVerPageBreakSize()); // Should be 1 now

// Test adding page break at different positions
var_dump($sheet->horPageBreak(18, true));
var_dump($sheet->verPageBreak(8, true));

// Final counts
var_dump($sheet->getHorPageBreakSize());
var_dump($sheet->getVerPageBreakSize());

echo "OK\n";
?>
--EXPECT--
int(0)
int(0)
bool(true)
bool(true)
bool(true)
int(3)
int(5)
int(10)
int(15)
bool(true)
bool(true)
int(2)
int(3)
int(6)
bool(true)
int(2)
bool(true)
int(1)
bool(true)
bool(true)
int(3)
int(2)
OK
