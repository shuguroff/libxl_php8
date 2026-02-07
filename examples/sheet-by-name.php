<?php
$book = new ExcelBook();

if ($book->load(__DIR__ . '/input.xls')) {
    $sheet1 = $book->getSheet(0);
    echo "First sheet: " . $sheet1->name() . "\n";

    $sheetByIndex = $book->getSheet(0);
    echo "Sheet by index 0: " . $sheetByIndex->name() . "\n";

    $sheetByName = $book->getSheetByName('Data');
    if ($sheetByName) {
        echo "Sheet by name 'Data': " . $sheetByName->name() . "\n";
    }

    $count = $book->sheetCount();
    echo "Total sheets: " . $count . "\n";

    for ($i = 0; $i < $count; $i++) {
        $sheet = $book->getSheet($i);
        echo "Sheet $i: " . $sheet->name() . "\n";
    }
}
