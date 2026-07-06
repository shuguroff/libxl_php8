<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Picture');

$pictureId = $book->addPictureFromFile(__DIR__ . '/logo.png');
if ($pictureId === false) {
    exit("Failed to load picture\n");
}

$sheet->addPictureScaled(2, 1, $pictureId, 2);
$sheet->addPictureDim(8, 1, $pictureId, 200, 150);

$book->save(__DIR__ . '/picture.xls');
