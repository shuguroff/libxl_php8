<?php
$book = new ExcelBook();
$sheet = $book->addSheet('Picture');

$pictureId = $book->addPictureFromFile(__DIR__ . '/image.png');

$sheet->addPictureScaled(2, 1, $pictureId, 2);
$sheet->addPictureDim(8, 1, $pictureId, 200, 150);

$book->save(__DIR__ . '/picture.xls');
