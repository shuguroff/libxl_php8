<?php
$book = new ExcelBook();

if ($book->load(__DIR__ . '/input.xls')) {
    $sheet = $book->getSheet(0);
    if ($sheet) {
        for ($row = $sheet->firstRow(); $row < $sheet->lastRow(); $row++) {
            for ($col = $sheet->firstCol(); $col < $sheet->lastCol(); $col++) {
                $cellType = $sheet->cellType($row, $col);
                echo "($row, $col) = ";

                if ($sheet->isFormula($row, $col)) {
                    $formula = $sheet->read($row, $col);
                    echo $formula . " [formula]";
                } else {
                    switch ($cellType) {
                        case ExcelSheet::CELLTYPE_EMPTY:
                            echo "[empty]";
                            break;
                        case ExcelSheet::CELLTYPE_NUMBER:
                            $d = $sheet->read($row, $col);
                            echo $d . " [number]";
                            break;
                        case ExcelSheet::CELLTYPE_STRING:
                            $s = $sheet->read($row, $col);
                            echo ($s !== null ? $s : "null") . " [string]";
                            break;
                        case ExcelSheet::CELLTYPE_BOOLEAN:
                            $b = $sheet->read($row, $col);
                            echo ($b ? "true" : "false") . " [boolean]";
                            break;
                        case ExcelSheet::CELLTYPE_BLANK:
                            echo "[blank]";
                            break;
                        case ExcelSheet::CELLTYPE_ERROR:
                            echo "[error]";
                            break;
                    }
                }
                echo "\n";
            }
        }
    }
}
