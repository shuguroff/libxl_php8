<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Sort Filter');

$format = $book->addFormat();
$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$sheet->write(0, 0, 'Name', $headerFormat);
$sheet->write(0, 1, 'Score', $headerFormat);

$data = [
    ['Alice', 85],
    ['Bob', 92],
    ['Charlie', 78],
    ['Diana', 95],
    ['Eve', 88],
    ['Frank', 72],
    ['Grace', 90],
    ['Henry', 68],
];

foreach ($data as $i => $row) {
    $sheet->write($i + 1, 0, $row[0], $format);
    $sheet->write($i + 1, 1, $row[1], $format);
}

$sheet->setColWidth(0, 0, 15);
$sheet->setColWidth(1, 1, 10);

$autoFilter = $sheet->autoFilter();
$autoFilter->setRef(0, 8, 0, 1);

$autoFilter->setSort(1, false);

$sheet->applyFilter();

$book->save(__DIR__ . '/sort-filter.xlsx');
