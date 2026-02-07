<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Begin With');

$format = $book->addFormat();

$sheet->write(0, 0, 'Product Code', $format);
$sheet->write(0, 1, 'Description', $format);

$data = [
    ['ABC-001', 'Widget A'],
    ['DEF-002', 'Widget D'],
    ['ABC-003', 'Widget B'],
    ['XYZ-999', 'Widget Z'],
    ['ABC-004', 'Widget C'],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 20);

$cfHighlight = $book->addConditionalFormat();
$cfHighlight->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$cfHighlight->patternForegroundColor(ExcelFormat::COLOR_LIGHTYELLOW);

$cfing = $sheet->addConditionalFormatting(0, 5, 0, 0);
$cfing->addOpStrRule(
    ExcelConditionalFormatting::CFOPERATOR_CONTAINSTEXT,
    $cfHighlight,
    'ABC',
    ''
);

$book->save(__DIR__ . '/begin-with.xlsx');
