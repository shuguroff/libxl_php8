<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Insert');

$format = $book->addFormat();

for ($col = 0; $col < 5; $col++) {
    for ($row = 0; $row < 10; $row++) {
        $sheet->write($row, $col, $row . ',' . $col, $format);
    }
}

$sheet->insertRow(2, 3);
$sheet->insertCol(1, 1);

$sheet->setRowHeight(2, 25);
$sheet->setColWidth(1, 1, 20);

for ($col = 0; $col < 6; $col++) {
    for ($row = 0; $row < 14; $row++) {
        $value = $sheet->read($row, $col);
        if ($value !== null) {
            $sheet->write($row, $col, $value . ' [inserted]', $format);
        }
    }
}

$book->save(__DIR__ . '/insert-row-col.xls');
