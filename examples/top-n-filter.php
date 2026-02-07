<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Top N Filter');

$format = $book->addFormat();
$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$sheet->write(0, 0, 'Product', $headerFormat);
$sheet->write(0, 1, 'Sales', $headerFormat);

$data = [
    ['Widget A', 150],
    ['Widget B', 300],
    ['Widget C', 450],
    ['Widget D', 200],
    ['Widget E', 500],
    ['Widget F', 100],
    ['Widget G', 400],
    ['Widget H', 250],
    ['Widget I', 350],
    ['Widget J', 175],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 10);

$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 10, 0, 1);

$filterColumn = $autoFilter->column(1);
$filterColumn->setTop10(5, true, false);

$sheet->applyFilter();

$book->save(__DIR__ . '/top-n-filter.xlsx');
