<?php
$book = new ExcelBook();
$sheet = $book->addSheet('DateTime');

$formatDate = $book->addFormat();
$formatDate->numberFormat(ExcelFormat::NUMFORMAT_DATE);

$formatTime = $book->addFormat();
$formatTime->numberFormat(ExcelFormat::NUMFORMAT_CUSTOM_HMMSS);

$formatDateTime = $book->addFormat();
$formatDateTime->numberFormat(ExcelFormat::NUMFORMAT_CUSTOM_MDYYYY_HMM);

$dateValue = $book->packDateValues(2024, 12, 25, 0, 0, 0);
$timeValue = $book->packDateValues(0, 0, 0, 14, 30, 45);
$dateTimeValue = $book->packDateValues(2024, 12, 25, 14, 30, 45);

$sheet->write(0, 0, 'Date:', $formatDate);
$sheet->write(0, 1, $dateValue, $formatDate);

$sheet->write(1, 0, 'Time:', $formatTime);
$sheet->write(1, 1, $timeValue, $formatTime);

$sheet->write(2, 0, 'DateTime:', $formatDateTime);
$sheet->write(2, 1, $dateTimeValue, $formatDateTime);

$book->save(__DIR__ . '/datetime.xls');

$book2 = new ExcelBook();
if (!$book2->loadFile(__DIR__ . '/datetime.xls')) {
    exit("Failed to load datetime.xls: " . $book2->getError() . "\n");
}
$sheet2 = $book2->getSheet(0);

// read() detects date-formatted cells and returns unix timestamps directly,
// no extra unpackDate() call is needed
$dateRead = $sheet2->read(0, 1);
$timeRead = $sheet2->read(1, 1);
$dateTimeRead = $sheet2->read(2, 1);

echo "Date read back: " . date('Y-m-d', $dateRead) . "\n";
echo "Time read back: " . date('H:i:s', $timeRead) . "\n";
echo "DateTime read back: " . date('Y-m-d H:i:s', $dateTimeRead) . "\n";
