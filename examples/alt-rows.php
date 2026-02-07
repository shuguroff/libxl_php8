<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Alt Rows');

$headerFormat = $book->addFormat();
$fontHeader = $book->addFont();
$fontHeader->bold(true);
$fontHeader->color(ExcelFormat::COLOR_WHITE);
$headerFormat->setFont($fontHeader);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);
$headerFormat->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$headerFormat->patternForegroundColor(ExcelFormat::COLOR_BLUE);

$formatEven = $book->addFormat();
$formatEven->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$formatEven->patternForegroundColor(ExcelFormat::COLOR_GRAY25);

$formatOdd = $book->addFormat();
$formatOdd->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$formatOdd->patternForegroundColor(ExcelFormat::COLOR_WHITE);

$sheet->write(0, 0, 'ID', $headerFormat);
$sheet->write(0, 1, 'Name', $headerFormat);
$sheet->write(0, 2, 'Value', $headerFormat);

for ($row = 1; $row <= 10; $row++) {
    $rowFormat = ($row % 2 == 0) ? $formatEven : $formatOdd;
    $sheet->write($row, 0, $row, $rowFormat);
    $sheet->write($row, 1, 'Item ' . $row, $rowFormat);
    $sheet->write($row, 2, rand(1, 100), $rowFormat);
}

$sheet->setColWidth(0, 0, 8);
$sheet->setColWidth(1, 0, 15);
$sheet->setColWidth(2, 0, 12);

$book->save(__DIR__ . '/alt-rows.xlsx');
