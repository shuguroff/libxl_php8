<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Color Scale');

$format = $book->addFormat();

$sheet->write(0, 0, 'Value', $format);
$sheet->write(0, 1, 'Score', $format);

$data = [
    [10, 85],
    [20, 92],
    [30, 78],
    [40, 95],
    [50, 88],
    [60, 72],
    [70, 90],
    [80, 68],
    [90, 91],
    [100, 77],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 10);
$sheet->setColWidth(1, 1, 10);

$cfing = $sheet->addConditionalFormatting(0, 10, 1, 1);
$cfing->add3ColorScaleRule(
    ExcelFormat::COLOR_LIGHTGREEN,
    ExcelFormat::COLOR_YELLOW,
    ExcelFormat::COLOR_RED,
    ExcelConditionalFormatting::CFVO_MIN, 0,
    ExcelConditionalFormatting::CFVO_PERCENTILE, 50,
    ExcelConditionalFormatting::CFVO_MAX, 0
);

$book->save(__DIR__ . '/color-scale.xlsx');
