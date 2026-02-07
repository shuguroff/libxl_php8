<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Replace Test');

$format = $book->addFormat();

$sheet->write(0, 0, 'Hello World', $format);
$sheet->write(1, 0, 'Hello PHP', $format);
$sheet->write(2, 0, 'Goodbye World', $format);
$sheet->write(3, 0, 'World Cup', $format);

$sheet->write(0, 1, 'Red Apple', $format);
$sheet->write(1, 1, 'Green Apple', $format);

$book->save(__DIR__ . '/before-replace.xls');

$book2 = new ExcelBook();
$book2->load(__DIR__ . '/before-replace.xls');

for ($i = 0; $i < $book2->sheetCount(); $i++) {
    $sheet2 = $book2->getSheet($i);

    for ($row = $sheet2->firstRow(); $row < $sheet2->lastRow(); $row++) {
        for ($col = $sheet2->firstCol(); $col < $sheet2->lastCol(); $col++) {
            $cellType = $sheet2->cellType($row, $col);

            if ($cellType == ExcelSheet::CELLTYPE_STRING) {
                $value = $sheet2->read($row, $col);
                if ($value !== null && strpos($value, 'World') !== false) {
                    $newValue = str_replace('World', 'Universe', $value);
                    $format = $sheet2->cellFormat($row, $col);
                    $sheet2->write($row, $col, $newValue, $format);
                }
            }
        }
    }
}

$book2->save(__DIR__ . '/after-replace.xls');

echo "Replaced 'World' with 'Universe' in all cells\n";
