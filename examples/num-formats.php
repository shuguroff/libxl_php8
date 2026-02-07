<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Number Formats');

$formatCurrency = $book->addFormat();
$formatCurrency->numberFormat(ExcelFormat::NUMFORMAT_CURRENCY_NEGBRA);

$formatPercent = $book->addFormat();
$formatPercent->numberFormat(ExcelFormat::NUMFORMAT_PERCENT);

$formatDate = $book->addFormat();
$formatDate->numberFormat(ExcelFormat::NUMFORMAT_DATE);

$formatScientific = $book->addFormat();
$formatScientific->numberFormat(ExcelFormat::NUMFORMAT_SCIENTIFIC_D2);

$formatCustom = $book->addFormat();
$formatCustom->numberFormat($book->addCustomFormat('#,##0.00 "USD"'));

$sheet->write(0, 0, 'Currency:', $formatCurrency);
$sheet->write(0, 1, 1234.56, $formatCurrency);

$sheet->write(1, 0, 'Percent:', $formatPercent);
$sheet->write(1, 1, 0.75, $formatPercent);

$sheet->write(2, 0, 'Date:', $formatDate);
$sheet->write(2, 1, $book->packDateValues(2024, 12, 25, 0, 0, 0), $formatDate);

$sheet->write(3, 0, 'Scientific:', $formatScientific);
$sheet->write(3, 1, 1234567.89, $formatScientific);

$sheet->write(4, 0, 'Custom USD:', $formatCustom);
$sheet->write(4, 1, 9876.54, $formatCustom);

$book->save(__DIR__ . '/num-formats.xls');
