<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Merged Cells');

$format = $book->addFormat();

$sheet->setMerge(0, 0, 0, 3);
$sheet->write(0, 0, 'Merged Title', $format);

$sheet->setMerge(2, 3, 1, 2);
$sheet->write(2, 1, 'Center Merge', $format);

$formatBold = $book->addFormat();
$fontBold = $book->addFont();
$fontBold->bold(true);
$formatBold->setFont($fontBold);

$sheet->setMerge(5, 5, 0, 4);
$sheet->write(5, 0, 'Bold Merged Header', $formatBold);

$book->save(__DIR__ . '/merging.xls');
