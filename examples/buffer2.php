<?php
$excelData = file_get_contents(__DIR__ . '/output.bin');

if ($excelData !== false) {
    $book = new ExcelBook();
    $loadResult = $book->load($excelData);

    if ($loadResult) {
        $sheet = $book->getSheet(0);

        for ($row = $sheet->firstRow(); $row < min($sheet->lastRow(), 10); $row++) {
            for ($col = $sheet->firstCol(); $col < min($sheet->lastCol(), 5); $col++) {
                $value = $sheet->read($row, $col);
                echo "($row, $col) = " . ($value !== null ? $value : '[empty]') . "\n";
            }
        }
    } else {
        echo "Error loading Excel file from memory\n";
    }
} else {
    echo "Error reading binary file\n";
}
