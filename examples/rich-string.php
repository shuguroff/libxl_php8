<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Rich Text');

$fontNormal = $book->addFont();
$fontNormal->name('Arial');
$fontNormal->size(12);

$fontBold = $book->addFont();
$fontBold->name('Arial');
$fontBold->size(12);
$fontBold->bold(true);

$fontItalic = $book->addFont();
$fontItalic->name('Arial');
$fontItalic->size(12);
$fontItalic->italics(true);

$fontRed = $book->addFont();
$fontRed->name('Arial');
$fontRed->size(12);
$fontRed->color(ExcelFormat::COLOR_RED);

$format = $book->addFormat();

$richString = $book->addRichString();
$richString->addText('This is ', $fontNormal);
$richString->addText('bold', $fontBold);
$richString->addText(' and ', $fontNormal);
$richString->addText('italic', $fontItalic);
$richString->addText(' text!', $fontNormal);

$sheet->writeRichStr(0, 0, $richString, $format);

$richString2 = $book->addRichString();
$richString2->addText('Error: ', $fontRed);
$richString2->addText('File not found', $fontNormal);

$sheet->writeRichStr(2, 0, $richString2, $format);

$book->save(__DIR__ . '/rich-string.xls');
