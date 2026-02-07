<?php 

$useXlsxFormat = false;
$xlBook = new \ExcelBook(null, null, $useXlsxFormat);
$xlBook->setLocale('UTF-8');
$xlSheet = $xlBook->addSheet('Sheet1');
$xlSheet->write(3, 3, 'Hello world!');
$xlBook->save('test.xls');
