<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Formats');

$formatLeft = $book->addFormat();
$formatLeft->horizontalAlign(ExcelFormat::ALIGNH_LEFT);

$formatCenter = $book->addFormat();
$formatCenter->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$formatRight = $book->addFormat();
$formatRight->horizontalAlign(ExcelFormat::ALIGNH_RIGHT);

$formatTop = $book->addFormat();
$formatTop->verticalAlign(ExcelFormat::ALIGNV_TOP);

$formatMiddle = $book->addFormat();
$formatMiddle->verticalAlign(ExcelFormat::ALIGNV_CENTER);

$formatBottom = $book->addFormat();
$formatBottom->verticalAlign(ExcelFormat::ALIGNV_BOTTOM);

$formatBorder = $book->addFormat();
$formatBorder->borderStyle(ExcelFormat::BORDERSTYLE_THIN);
$formatBorder->borderColor(ExcelFormat::COLOR_RED);

$formatBg = $book->addFormat();
$formatBg->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$formatBg->patternForegroundColor(ExcelFormat::COLOR_YELLOW);

$sheet->write(0, 0, 'Left Align', $formatLeft);
$sheet->write(1, 0, 'Center Align', $formatCenter);
$sheet->write(2, 0, 'Right Align', $formatRight);

$sheet->write(0, 2, 'Top', $formatTop);
$sheet->write(1, 2, 'Middle', $formatMiddle);
$sheet->write(2, 2, 'Bottom', $formatBottom);

$sheet->write(4, 0, 'With Border', $formatBorder);

$sheet->write(6, 0, 'Yellow Background', $formatBg);

$book->save(__DIR__ . '/formats.xls');
