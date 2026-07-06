<?php
$book = new ExcelBook();

if ($book->loadFile(__DIR__ . '/receipt.xls')) {
    $sheet = $book->getSheet(0);

    for ($i = 0; $i < $sheet->getNumPictures(); $i++) {
        $pictureInfo = $sheet->getPictureInfo($i);
        $pictureData = $book->getPicture($pictureInfo['picture_index']);

        if ($pictureData) {
            switch ($pictureData['type']) {
                case ExcelBook::PICTURETYPE_PNG:
                    $extension = 'png';
                    break;
                case ExcelBook::PICTURETYPE_JPEG:
                    $extension = 'jpg';
                    break;
                default:
                    $extension = 'dat';
            }

            file_put_contents(__DIR__ . '/output_' . $i . '.' . $extension, $pictureData['data']);
            echo "Extracted picture $i (" . strlen($pictureData['data']) . " bytes) to output_$i.$extension\n";
        }
    }
} else {
    echo "Failed to load workbook: run write-excel-data.php first to create receipt.xls\n";
}
