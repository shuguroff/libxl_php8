<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Formulas');

$format = $book->addFormat();

$sheet->write(0, 0, 10, $format);
$sheet->write(0, 1, 20, $format);
$sheet->write(0, 2, 30, $format);

$sheet->writeFormula(0, 3, 'SUM(A1:C1)', $format);
$sheet->writeFormula(0, 4, 'AVERAGE(A1:C1)', $format);
$sheet->writeFormula(0, 5, 'MAX(A1:C1)', $format);
$sheet->writeFormula(0, 6, 'MIN(A1:C1)', $format);

$sheet->writeFormula(0, 7, 'IF(A1>5,"Big","Small")', $format);

$sheet->writeFormula(0, 8, 'CONCATENATE(A1," ",B1)', $format);

$book->save(__DIR__ . '/formulas.xls');
