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
$book2->load(__DIR__ . '/datetime.xls');
$sheet2 = $book2->getSheet(0);

$dateRead = $sheet2->read(0, 1);
$timeRead = $sheet2->read(1, 1);
$dateTimeRead = $sheet2->read(2, 1);

$dateUnpacked = $book2->unpackDate($dateRead);
$timeUnpacked = $book2->unpackDate($timeRead);
$dateTimeUnpacked = $book2->unpackDate($dateTimeRead);

echo "Date unpacked: " . date('Y-m-d', $dateUnpacked) . "\n";
echo "Time unpacked: " . date('H:i:s', $timeUnpacked) . "\n";
echo "DateTime unpacked: " . date('Y-m-d H:i:s', $dateTimeUnpacked) . "\n";
