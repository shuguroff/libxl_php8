<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Protected');

$format = $book->addFormat();

for ($row = 0; $row < 10; $row++) {
    for ($col = 0; $col < 5; $col++) {
        $sheet->write($row, $col, 'Cell ' . $row . '-' . $col, $format);
    }
}

$sheet->setProtect(true, 'password123', ExcelSheet::PROT_ALL);

$book->save(__DIR__ . '/protected.xls');

$book2 = new ExcelBook();
$book2->load(__DIR__ . '/protected.xls');
$sheet2 = $book2->getSheet(0);

echo "Sheet protected: " . ($sheet2->protect() ? 'Yes' : 'No') . "\n";
