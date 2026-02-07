<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Number Filter');

$format = $book->addFormat();
$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$sheet->write(0, 0, 'Item', $headerFormat);
$sheet->write(0, 1, 'Price', $headerFormat);

$data = [
    ['Product A', 10.99],
    ['Product B', 25.50],
    ['Product C', 5.00],
    ['Product D', 50.00],
    ['Product E', 15.75],
    ['Product F', 100.00],
    ['Product G', 30.00],
    ['Product H', 7.50],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 12);

$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 8, 0, 1);

$filterColumn = $autoFilter->column(1);
$filterColumn->setCustomFilter(ExcelFilterColumn::OPERATOR_GREATER_THAN, 20);

$sheet->applyFilter();

$book->save(__DIR__ . '/number-filter.xlsx');
