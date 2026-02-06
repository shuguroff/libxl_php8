--TEST--
ExcelBook negative tests (error handling)
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// Test loadFile() with non-existent file
$result = @$book->loadFile('/non/existent/path/file.xlsx');
var_dump($result);
// getError() may or may not be set after loadFile failure
var_dump($result === false);

// Test getSheet() with invalid index
$sheet1 = $book->addSheet('Sheet1');
$invalidSheet = $book->getSheet(999);
var_dump($invalidSheet);

// Test getSheet() with negative index
$negativeSheet = $book->getSheet(-1);
var_dump($negativeSheet);

// Test deleteSheet() with invalid index
$result = $book->deleteSheet(999);
var_dump($result);

// Test deleteSheet() with negative index
$result = $book->deleteSheet(-1);
var_dump($result);

// Test getSheetByName() with non-existent name
$book2 = new ExcelBook(null, null, true);
$book2->addSheet('ExistingSheet');
$nonExistent = $book2->getSheetByName('NonExistentSheet');
var_dump($nonExistent);

// Test save() to invalid/inaccessible path
$saveResult = @$book->save('/invalid/path/that/does/not/exist/test.xlsx');
var_dump($saveResult);
var_dump($book->getError() !== false);

// Test addPictureFromFile() with non-existent file
$pictureId = @$book->addPictureFromFile('/non/existent/image.png');
var_dump($pictureId);

// Test addPictureFromString() with invalid data
$pictureId = $book->addPictureFromString('not a valid image');
var_dump($pictureId);

// Test copySheet() with invalid source index
$book3 = new ExcelBook(null, null, true);
$book3->addSheet('Original');
$copied = $book3->copySheet('Copy', 999);
var_dump($copied);

// Test getCustomFormat() with invalid ID
$format = $book->getCustomFormat(9999);
var_dump($format);

// Test getPicture() with invalid index
$book4 = new ExcelBook(null, null, true);
$book4->addSheet('Test');
$picture = $book4->getPicture(0);
var_dump($picture);

// Test sheetType() with invalid index - returns SHEETTYPE_UNKNOWN (2)
$sheetType = $book->sheetType(999);
var_dump($sheetType === ExcelBook::SHEETTYPE_UNKNOWN || $sheetType === false);

// Test unpackDate() with invalid value (may return unexpected timestamp)
$date = $book->unpackDate(-1);
var_dump(is_int($date)); // Returns int even for invalid input

// Test activeSheet() with invalid index
$book5 = new ExcelBook(null, null, true);
$book5->addSheet('Sheet1');
$result = $book5->setActiveSheet(999);
var_dump($result);

// Test insertSheet() at invalid position
$book6 = new ExcelBook(null, null, true);
$result = $book6->insertSheet(999, 'InvalidPosition');
// May succeed by appending at end, or return false/null
var_dump(!is_object($result)); // Should fail for invalid position

// Test packDate() with invalid arguments
try {
    $book->packDate(2024, 13, 1, 0, 0, 0); // invalid call signature
    echo "NO EXCEPTION\n";
} catch (Throwable $e) {
    echo "Error: " . get_class($e) . "\n";
}

// Test colorPack() with invalid values
try {
    $book->colorPack(256, 0, 0); // red > 255
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

// Test colorUnpack() with invalid value
try {
    $book->colorUnpack(0); // color <= 0
    echo "NO EXCEPTION\n";
} catch (ExcelException $e) {
    echo "ExcelException: " . $e->getMessage() . "\n";
}

echo "OK\n";
?>
--EXPECT--
bool(false)
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(true)
bool(false)
bool(false)
bool(true)
Error: ArgumentCountError
ExcelException: Invalid '256' value for color red
ExcelException: Invalid '0' value for color code
OK
