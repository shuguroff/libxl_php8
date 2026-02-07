<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Op Rule');

$format = $book->addFormat();

$sheet->write(0, 0, 'Product', $format);
$sheet->write(0, 1, 'Price', $format);

$data = [
    ['Widget A', 10],
    ['Widget B', 25],
    ['Widget C', 5],
    ['Widget D', 50],
    ['Widget E', 15],
    ['Widget F', 100],
    ['Widget G', 30],
    ['Widget H', 7],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 12);

$cfHighlight = $book->addConditionalFormat();
$cfHighlight->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$cfHighlight->patternForegroundColor(ExcelFormat::COLOR_LIGHTGREEN);

$cfing = $sheet->addConditionalFormatting(0, 8, 1, 1);
$cfing->addOpNumRule(
    ExcelConditionalFormatting::CFOPERATOR_GREATER_THAN,
    $cfHighlight,
    20,
    0
);

$book->save(__DIR__ . '/op-rule.xlsx');
