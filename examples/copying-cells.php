<?php
$srcBook = new ExcelBook();
if (!$srcBook->loadFile(__DIR__ . '/receipt.xls')) {
    exit("Failed to load workbook: run write-excel-data.php first to create receipt.xls\n");
}

$srcSheet = $srcBook->getSheet(0);

$dstBook = new ExcelBook();
$dstSheet = $dstBook->addSheet('my');

for ($col = $srcSheet->firstCol(); $col < $srcSheet->lastCol(); $col++) {
    $dstSheet->setColWidth($col, $col, $srcSheet->colWidth($col), $srcSheet->colHidden($col));
}

for ($i = 0; $i < $srcSheet->mergeSize(); $i++) {
    $merge = $srcSheet->merge($i);
    if ($merge) {
        $dstSheet->setMerge($merge['row_first'], $merge['row_last'], $merge['col_first'], $merge['col_last']);
    }
}

$formats = [];

for ($row = $srcSheet->firstRow(); $row < $srcSheet->lastRow(); $row++) {
    $dstSheet->setRowHeight($row, $srcSheet->rowHeight($row), null, $srcSheet->rowHidden($row));

    for ($col = $srcSheet->firstCol(); $col < $srcSheet->lastCol(); $col++) {
        $srcFormat = $srcSheet->cellFormat($row, $col);
        if (!$srcFormat) {
            continue;
        }

        // keep $srcFormat referenced in the map: spl_object_id() values are
        // reused once an object is destroyed
        if (!isset($formats[spl_object_id($srcFormat)])) {
            $dstFormat = $dstBook->addFormat($srcFormat);
            $formats[spl_object_id($srcFormat)] = [$srcFormat, $dstFormat];
        } else {
            $dstFormat = $formats[spl_object_id($srcFormat)][1];
        }

        $ct = $srcSheet->cellType($row, $col);
        switch ($ct) {
            case ExcelSheet::CELLTYPE_NUMBER:
                $value = $srcSheet->read($row, $col);
                $dstSheet->write($row, $col, $value, $dstFormat);
                break;
            case ExcelSheet::CELLTYPE_BOOLEAN:
                $value = $srcSheet->read($row, $col);
                $dstSheet->write($row, $col, $value, $dstFormat);
                break;
            case ExcelSheet::CELLTYPE_STRING:
                $value = $srcSheet->read($row, $col);
                $dstSheet->write($row, $col, $value, $dstFormat);
                break;
            case ExcelSheet::CELLTYPE_BLANK:
                $dstSheet->write($row, $col, '', $dstFormat);
                break;
        }
    }
}

$dstBook->save(__DIR__ . '/out.xls');
