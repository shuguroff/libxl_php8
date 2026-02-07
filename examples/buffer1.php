<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Data');

$format = $book->addFormat();

for ($row = 0; $row < 100; $row++) {
    for ($col = 0; $col < 10; $col++) {
        $sheet->write($row, $col, 'Data ' . $row . '-' . $col, $format);
    }
}

$excelData = $book->save();

file_put_contents(__DIR__ . '/output.bin', $excelData);

echo "Excel file saved to memory buffer. Size: " . strlen($excelData) . " bytes\n";
