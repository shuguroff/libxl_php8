--TEST--
ExcelSheet::writeStrAsNum()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'writeStrAsNum')) die('skip ExcelSheet::writeStrAsNum() not available');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// writeStrAsNum() writes a string as a number
$result = $sheet->writeStrAsNum(0, 0, '12345');
var_dump($result);

// writeStrAsNum() with format
$format = $book->addFormat();
$result = $sheet->writeStrAsNum(1, 0, '67.89', $format);
var_dump($result);

// read back the values - they should be numeric
$val = $sheet->read(0, 0);
var_dump(is_numeric($val));
var_dump((float)$val == 12345.0);

$val2 = $sheet->read(1, 0);
var_dump(is_numeric($val2));
var_dump(abs((float)$val2 - 67.89) < 0.001);

// writeStrAsNum() with invalid row should throw
try {
    $sheet->writeStrAsNum(-1, 0, '123');
    echo "no exception\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
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
ExcelException: Invalid row or column number
OK
