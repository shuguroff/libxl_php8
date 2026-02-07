<?php
$book = new ExcelBook();
$sheet = $book->addSheet('String Filter');

$format = $book->addFormat();
$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$sheet->write(0, 0, 'Category', $headerFormat);
$sheet->write(0, 1, 'Product', $headerFormat);

$data = [
    ['Apple', 'iPhone'],
    ['Apple', 'iPad'],
    ['Samsung', 'Galaxy S'],
    ['Samsung', 'Galaxy Tab'],
    ['Google', 'Pixel'],
    ['Apple', 'MacBook'],
    ['Microsoft', 'Surface'],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 15);

$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 7, 0, 1);

$filterColumn = $autoFilter->column(0);
$filterColumn->setCustomFilter(ExcelFilterColumn::OPERATOR_EQUAL, 'Apple');

$sheet->applyFilter();

$book->save(__DIR__ . '/string-filter.xlsx');
