<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Test');

// defaultRowHeight() returns a float
$h = $sheet->defaultRowHeight();
var_dump(is_float($h));
var_dump($h > 0);

// setDefaultRowHeight() changes the value
$sheet->setDefaultRowHeight(25.5);
$h2 = $sheet->defaultRowHeight();
var_dump(abs($h2 - 25.5) < 0.01);

echo "OK\n";
?>
