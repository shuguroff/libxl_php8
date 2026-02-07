<?php
$book = new ExcelBook(null, null, false);

$logoId = $book->addPictureFromFile(__DIR__ . '/logo.png');

$textFont = $book->addFont();
$textFont->size(8);
$textFont->name('Century Gothic');

$titleFont = $book->addFont($textFont);
$titleFont->size(38);
$titleFont->color(ExcelFormat::COLOR_GRAY25);

$font12 = $book->addFont($textFont);
$font12->size(12);

$font10 = $book->addFont($textFont);
$font10->size(10);

$textFormat = $book->addFormat();
$textFormat->setFont($textFont);
$textFormat->horizontalAlign(ExcelFormat::ALIGNH_LEFT);

$titleFormat = $book->addFormat();
$titleFormat->setFont($titleFont);
$titleFormat->horizontalAlign(ExcelFormat::ALIGNH_RIGHT);

$companyFormat = $book->addFormat();
$companyFormat->setFont($font12);

$dateFormat = $book->addFormat($textFormat);
$dateFormat->numberFormat($book->addCustomFormat('[$-409]mmmm\ d,\ yyyy;@'));

$phoneFormat = $book->addFormat($textFormat);
$phoneFormat->numberFormat($book->addCustomFormat('[<=9999999]###\-####;\(###\)\ ###\-####'));

$borderFormat = $book->addFormat($textFormat);
$borderFormat->borderStyle(ExcelFormat::BORDERSTYLE_THIN);
$borderFormat->borderColor(ExcelFormat::COLOR_GRAY25);
$borderFormat->verticalAlign(ExcelFormat::ALIGNV_CENTER);

$percentFormat = $book->addFormat($borderFormat);
$percentFormat->numberFormat($book->addCustomFormat('#%_'));
$percentFormat->horizontalAlign(ExcelFormat::ALIGNH_RIGHT);

$textRightFormat = $book->addFormat($textFormat);
$textRightFormat->horizontalAlign(ExcelFormat::ALIGNH_RIGHT);
$textRightFormat->verticalAlign(ExcelFormat::ALIGNV_CENTER);

$thankFormat = $book->addFormat();
$thankFormat->setFont($font10);
$thankFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);

$dollarFormat = $book->addFormat($borderFormat);
$dollarFormat->numberFormat($book->addCustomFormat('_($* # ##0.00_);_($* (# ##0.00);_($* -??_);_(@_)'));

$sheet = $book->addSheet('Sales Receipt');
$sheet->setDisplayGridlines(false);
$sheet->setColWidth(1, 1, 36);
$sheet->setColWidth(0, 0, 10);
$sheet->setColWidth(2, 4, 11);
$sheet->setRowHeight(2, 47.25);

$sheet->write(2, 1, 'Sales Receipt', $titleFormat);
$sheet->setMerge(2, 2, 1, 4);
$sheet->addPictureDim(2, 1, $logoId, 100, 50);

$sheet->write(4, 0, 'Apricot Ltd.', $companyFormat);
$sheet->write(4, 3, 'Date:', $textFormat);
$sheet->writeFormula(4, 4, 'TODAY()', $dateFormat);

$sheet->write(5, 3, 'Receipt #:', $textFormat);
$sheet->write(5, 4, 652, $textFormat);

$sheet->write(8, 0, 'Sold to:', $textFormat);
$sheet->write(8, 1, 'John Smith', $textFormat);
$sheet->write(9, 1, 'Pineapple Ltd.', $textFormat);
$sheet->write(10, 1, '123 Dreamland Street', $textFormat);
$sheet->write(11, 1, 'Moema, 52674', $textFormat);
$sheet->write(12, 1, 2659872055, $phoneFormat);

$sheet->write(14, 0, 'Item #', $textFormat);
$sheet->write(14, 1, 'Description', $textFormat);
$sheet->write(14, 2, 'Qty', $textFormat);
$sheet->write(14, 3, 'Unit Price', $textFormat);
$sheet->write(14, 4, 'Line Total', $textFormat);

for ($row = 15; $row < 38; $row++) {
    $sheet->setRowHeight($row, 15);
    for ($col = 0; $col < 3; $col++) {
        $sheet->write($row, $col, '', $borderFormat);
    }
    $sheet->write($row, 3, '', $dollarFormat);
    $formula = "IF(C" . ($row + 1) . ">0;ABS(C" . ($row + 1) . "*D" . ($row + 1) . ");\"\")";
    $sheet->writeFormula($row, 4, $formula, $dollarFormat);
}

$sheet->write(38, 3, 'Subtotal ', $textRightFormat);
$sheet->write(39, 3, 'Sales Tax ', $textRightFormat);
$sheet->write(40, 3, 'Total ', $textRightFormat);
$sheet->writeFormula(38, 4, 'SUM(E16:E38)', $dollarFormat);
$sheet->write(39, 4, 0.2, $percentFormat);
$sheet->writeFormula(40, 4, 'E39+E39*E40', $dollarFormat);

$sheet->setRowHeight(38, 15);
$sheet->setRowHeight(39, 15);
$sheet->setRowHeight(40, 15);

$sheet->write(42, 0, 'Thank you for your business!', $thankFormat);
$sheet->setMerge(42, 42, 0, 4);

$sheet->write(15, 0, 45, $borderFormat);
$sheet->write(15, 1, 'Grapes', $borderFormat);
$sheet->write(15, 2, 250, $borderFormat);
$sheet->write(15, 3, 4.5, $dollarFormat);

$sheet->write(16, 0, 12, $borderFormat);
$sheet->write(16, 1, 'Bananas', $borderFormat);
$sheet->write(16, 2, 480, $borderFormat);
$sheet->write(16, 3, 1.4, $dollarFormat);

$sheet->write(17, 0, 19, $borderFormat);
$sheet->write(17, 1, 'Apples', $borderFormat);
$sheet->write(17, 2, 180, $borderFormat);
$sheet->write(17, 3, 2.8, $dollarFormat);

$book->save(__DIR__ . '/receipt.xls');
