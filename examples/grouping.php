<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Grouping');

$format = $book->addFormat();

for ($row = 0; $row < 10; $row++) {
    for ($col = 0; $col < 5; $col++) {
        $sheet->write($row, $col, 'Data ' . $row . '-' . $col, $format);
    }
}

$sheet->groupRows(1, 3);
$sheet->groupRows(4, 6);
$sheet->groupCols(1, 2);

$sheet->setGroupSummaryBelow(true);
$sheet->setGroupSummaryRight(true);

$book->save(__DIR__ . '/grouping.xls');
