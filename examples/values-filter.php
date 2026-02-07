<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Values Filter');

$format = $book->addFormat();
$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$sheet->write(0, 0, 'Region', $headerFormat);
$sheet->write(0, 1, 'Sales', $headerFormat);

$data = [
    ['North', 15000],
    ['South', 22000],
    ['East', 18000],
    ['West', 25000],
    ['North', 12000],
    ['South', 19000],
    ['East', 21000],
    ['West', 28000],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 12);

$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 8, 0, 1);

$filterColumn = $autoFilter->column(0);
$filterColumn->addFilter('North');
$filterColumn->addFilter('South');

$sheet->applyFilter();

$book->save(__DIR__ . '/values-filter.xlsx');
