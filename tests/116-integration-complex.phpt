--TEST--
Complex integration test with multiple features
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
// Create a complex workbook with multiple features
$book = new ExcelBook(null, null, true);

// ---- Sheet 1: Data with formatting ----
$dataSheet = $book->addSheet('Data');

// Create fonts
$boldFont = $book->addFont();
$boldFont->bold(true);
$boldFont->size(12);

$italicFont = $book->addFont();
$italicFont->italics(true);
$italicFont->color(ExcelFormat::COLOR_BLUE);

// Create formats
$headerFormat = $book->addFormat();
$headerFormat->setFont($boldFont);
$headerFormat->fillPattern(ExcelFormat::FILLPATTERN_SOLID);
$headerFormat->patternForegroundColor(ExcelFormat::COLOR_LIGHTYELLOW);
$headerFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);
$headerFormat->borderStyle(ExcelFormat::BORDERSTYLE_THIN);

$currencyFormat = $book->addFormat();
$currencyFormat->numberFormat(ExcelFormat::NUMFORMAT_CURRENCY_D2_NEGBRA);

$percentFormat = $book->addFormat();
$percentFormat->numberFormat(ExcelFormat::NUMFORMAT_PERCENT_D2);

$dateFormat = $book->addFormat();
$dateFormat->numberFormat(ExcelFormat::NUMFORMAT_DATE);

// Write header row
$headers = ['ID', 'Product', 'Price', 'Quantity', 'Discount', 'Total', 'Date'];
$dataSheet->writeRow(0, $headers, 0, $headerFormat);

// Write data rows
$data = [
    [1, 'Widget A', 29.99, 10, 0.1, '=C2*D2*(1-E2)', $book->packDateValues(2024, 1, 15, 0, 0, 0)],
    [2, 'Widget B', 49.99, 5, 0.15, '=C3*D3*(1-E3)', $book->packDateValues(2024, 2, 20, 0, 0, 0)],
    [3, 'Widget C', 19.99, 25, 0.05, '=C4*D4*(1-E4)', $book->packDateValues(2024, 3, 10, 0, 0, 0)],
];

$row = 1;
foreach ($data as $rowData) {
    $dataSheet->write($row, 0, $rowData[0]);
    $dataSheet->write($row, 1, $rowData[1]);
    $dataSheet->write($row, 2, $rowData[2], $currencyFormat);
    $dataSheet->write($row, 3, $rowData[3]);
    $dataSheet->write($row, 4, $rowData[4], $percentFormat);
    $dataSheet->write($row, 5, $rowData[5], $currencyFormat, ExcelFormat::AS_FORMULA);
    $dataSheet->write($row, 6, $rowData[6], $dateFormat);
    $row++;
}

// Add total row
$totalFormat = $book->addFormat();
$totalFormat->setFont($boldFont);
$totalFormat->numberFormat(ExcelFormat::NUMFORMAT_CURRENCY_D2_NEGBRA);

$dataSheet->write(4, 4, 'Total:');
$dataSheet->write(4, 5, '=SUM(F2:F4)', $totalFormat, ExcelFormat::AS_FORMULA);

// Set column widths
$dataSheet->setColWidth(0, 0, 5);
$dataSheet->setColWidth(1, 1, 15);
$dataSheet->setColWidth(2, 2, 12);
$dataSheet->setColWidth(3, 3, 10);
$dataSheet->setColWidth(4, 4, 10);
$dataSheet->setColWidth(5, 5, 12);
$dataSheet->setColWidth(6, 6, 12);

// Create named range
$dataSheet->setNamedRange('ProductData', 0, 0, 4, 6);

// Add hyperlink
$dataSheet->addHyperlink('https://example.com', 5, 5, 0, 0);
$dataSheet->write(5, 0, 'Example Link');

// ---- Sheet 2: Chart placeholder and merged cells ----
$summarySheet = $book->addSheet('Summary');

// Merge cells for title
$summarySheet->setMerge(0, 0, 0, 3);
$titleFormat = $book->addFormat();
$titleFormat->setFont($boldFont);
$titleFormat->horizontalAlign(ExcelFormat::ALIGNH_CENTER);
$titleFormat->verticalAlign(ExcelFormat::ALIGNV_CENTER);
$summarySheet->write(0, 0, 'Sales Summary Report', $titleFormat);
$summarySheet->setRowHeight(0, 30);

// Add some summary data
$summarySheet->write(2, 0, 'Total Products:');
$summarySheet->write(2, 1, 3);
$summarySheet->write(3, 0, 'Total Value:');
$summarySheet->write(3, 1, '=Data!F5', null, ExcelFormat::AS_FORMULA);

// Group some rows
$summarySheet->write(5, 0, 'Detail 1');
$summarySheet->write(6, 0, 'Detail 2');
$summarySheet->write(7, 0, 'Detail 3');
$summarySheet->groupRows(5, 7, true); // Collapsed group

// ---- Sheet 3: Print settings demo ----
$printSheet = $book->addSheet('PrintDemo');

// Write grid of data
for ($i = 0; $i < 50; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $printSheet->write($i, $j, "R{$i}C{$j}");
    }
}

// Set print settings
$printSheet->setLandscape(true);
$printSheet->setPaper(ExcelSheet::PAPER_A4);
$printSheet->setPrintRepeatRows(0, 0); // Repeat first row
$printSheet->setPrintArea(0, 49, 0, 9);
$printSheet->setPrintFit(1, 0); // Fit width to 1 page
$printSheet->setHeader('Page &P of &N', 0.5);
$printSheet->setFooter('Confidential', 0.5);
$printSheet->setMarginTop(1.0);
$printSheet->setMarginBottom(1.0);
$printSheet->setMarginLeft(0.75);
$printSheet->setMarginRight(0.75);

// Add page breaks
$printSheet->horPageBreak(25, true);
$printSheet->verPageBreak(5, true);

// ---- Verify structure ----
var_dump($book->sheetCount());
var_dump($book->getSheet(0)->name());
var_dump($book->getSheet(1)->name());
var_dump($book->getSheet(2)->name());

// Verify data on Sheet 1
var_dump($dataSheet->read(0, 0)); // Header
var_dump($dataSheet->read(1, 1)); // Product name
var_dump($dataSheet->isFormula(1, 5)); // Formula cell

// Verify merge on Sheet 2
$merge = $summarySheet->getMerge(0, 0);
var_dump($merge['col_last']);

// Verify print settings on Sheet 3
var_dump($printSheet->landscape());
var_dump($printSheet->paper() === ExcelSheet::PAPER_A4);
$printFit = $printSheet->getPrintFit();
var_dump($printFit['width']);

// ---- Save, reload, and verify persistence ----
$savedData = $book->save();
var_dump(strlen($savedData) > 1000);

$book2 = new ExcelBook(null, null, true);
var_dump($book2->load($savedData));

// Verify sheets exist
var_dump($book2->sheetCount());

$reloadedData = $book2->getSheet(0);
var_dump($reloadedData->name());

// Verify some data survived
var_dump($reloadedData->read(0, 0)); // Header
var_dump($reloadedData->read(1, 1)); // Product name
var_dump($reloadedData->read(1, 2)); // Price

// Verify formatting survived (check via cellFormat)
$fmt = $reloadedData->cellFormat(0, 0);
var_dump($fmt instanceof ExcelFormat);

// Verify named range survived
$range = $reloadedData->getNamedRange('ProductData');
var_dump($range !== false);

// Verify hyperlink survived
var_dump($reloadedData->hyperlinkSize());

echo "OK\n";
?>
--EXPECT--
int(3)
string(4) "Data"
string(7) "Summary"
string(9) "PrintDemo"
string(2) "ID"
string(8) "Widget A"
bool(true)
int(3)
bool(true)
bool(true)
int(1)
bool(true)
bool(true)
int(3)
string(4) "Data"
string(2) "ID"
string(8) "Widget A"
float(29.99)
bool(true)
bool(true)
int(1)
OK
