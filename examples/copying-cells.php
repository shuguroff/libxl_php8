<?php
$srcBook = new ExcelBook();
$srcBook->load(__DIR__ . '/data.xls');

$srcSheet = $srcBook->getSheet(0);

$dstBook = new ExcelBook();
$dstSheet = $dstBook->addSheet('my');

for ($col = $srcSheet->firstCol(); $col < $srcSheet->lastCol(); $col++) {
    $dstSheet->setColWidth($col, $col, $srcSheet->colWidth($col), false, $srcSheet->colHidden($col));
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

        if (!isset($formats[spl_object_id($srcFormat)])) {
            $dstFormat = $dstBook->addFormat($srcFormat);
            $formats[spl_object_id($srcFormat)] = $dstFormat;
        } else {
            $dstFormat = $formats[spl_object_id($srcFormat)];
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
