--TEST--
ExcelSheet picture methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Pictures Test');

// Test getNumPictures() - should be 0 initially
var_dump($sheet->getNumPictures());

// Add a picture to the workbook
$pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mNk+M9QzwAEjFQMRgYKAPkCDKEDR4UAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAASUVORK5CYII=');
$pictureId1 = $book->addPictureFromString($pngData);
var_dump($pictureId1 !== false);

// Add picture to sheet using addPictureScaled
$sheet->addPictureScaled(0, 0, $pictureId1, 1.0);

// Test getNumPictures() - should be 1 now
var_dump($sheet->getNumPictures());

// Add another picture with dimensions
$sheet->addPictureDim(5, 0, $pictureId1, 100, 100);

// Test getNumPictures() - should be 2 now
var_dump($sheet->getNumPictures());

// Test getPictureInfo()
$info1 = $sheet->getPictureInfo(0);
var_dump(is_array($info1));
var_dump(isset($info1['picture_index']));
var_dump(isset($info1['row_top']));
var_dump(isset($info1['col_left']));
var_dump(isset($info1['row_bottom']));
var_dump(isset($info1['col_right']));
var_dump(isset($info1['width']));
var_dump(isset($info1['height']));
var_dump(isset($info1['offset_x']));
var_dump(isset($info1['offset_y']));

// Check first picture position
var_dump($info1['row_top']);
var_dump($info1['col_left']);

// Test getPictureInfo() for second picture
$info2 = $sheet->getPictureInfo(1);
var_dump(is_array($info2));
var_dump($info2['row_top']);
var_dump($info2['col_left']);
var_dump($info2['width']);
var_dump($info2['height']);

// Test addPictureScaled with offset
$sheet->addPictureScaled(10, 2, $pictureId1, 2.0, 10, 10);
var_dump($sheet->getNumPictures());

// Test addPictureDim with offset
$sheet->addPictureDim(15, 3, $pictureId1, 50, 50, 5, 5);
var_dump($sheet->getNumPictures());

// Verify offsets in picture info
$info4 = $sheet->getPictureInfo(3);
var_dump($info4['offset_x']);
var_dump($info4['offset_y']);

echo "OK\n";
?>
--EXPECT--
int(0)
bool(true)
int(1)
int(2)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(0)
int(0)
bool(true)
int(5)
int(0)
int(100)
int(100)
int(3)
int(4)
int(5)
int(5)
OK
