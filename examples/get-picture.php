<?php
$book = new ExcelBook();

if ($book->load(__DIR__ . '/input.xls')) {
    $sheet = $book->getSheet(0);

    for ($i = 0; $i < $sheet->getNumPictures(); $i++) {
        $pictureInfo = $sheet->getPictureInfo($i);
        $pictureData = $book->getPicture($pictureInfo['picture_index']);

        if ($pictureData) {
            $extension = match ($pictureData['type']) {
                ExcelBook::PICTURETYPE_PNG => 'png',
                ExcelBook::PICTURETYPE_JPEG => 'jpg',
                default => 'dat',
            };

            file_put_contents(__DIR__ . '/output_' . $i . '.' . $extension, $pictureData['data']);
        }
    }
}
