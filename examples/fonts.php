<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Fonts');

$fontArial = $book->addFont();
$fontArial->name('Arial');
$fontArial->size(12);

$formatArial = $book->addFormat();
$formatArial->setFont($fontArial);

$fontBold = $book->addFont();
$fontBold->name('Times New Roman');
$fontBold->size(14);
$fontBold->bold(true);

$formatBold = $book->addFormat();
$formatBold->setFont($fontBold);

$fontItalic = $book->addFont();
$fontItalic->name('Courier New');
$fontItalic->size(10);
$fontItalic->italics(true);

$formatItalic = $book->addFormat();
$formatItalic->setFont($fontItalic);

$fontUnderline = $book->addFont();
$fontUnderline->name('Verdana');
$fontUnderline->size(11);
$fontUnderline->underline(ExcelFont::UNDERLINE_SINGLE);

$formatUnderline = $book->addFormat();
$formatUnderline->setFont($fontUnderline);

$fontColor = $book->addFont();
$fontColor->name('Georgia');
$fontColor->size(16);
$fontColor->color(ExcelFormat::COLOR_RED);

$formatColor = $book->addFormat();
$formatColor->setFont($fontColor);

$sheet->write(0, 0, 'Regular Arial 12', $formatArial);
$sheet->write(1, 0, 'Bold Times New Roman 14', $formatBold);
$sheet->write(2, 0, 'Italic Courier New 10', $formatItalic);
$sheet->write(3, 0, 'Underlined Verdana 11', $formatUnderline);
$sheet->write(4, 0, 'Red Georgia 16', $formatColor);

$book->save(__DIR__ . '/fonts.xls');
