--TEST--
ExcelBook miscellaneous methods tests
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
// Test biffVersion() for xls format
$bookXls = new ExcelBook(null, null, false);
$bookXls->addSheet('Test');
$biffXls = $bookXls->biffVersion();
var_dump($biffXls > 0); // BIFF8 = 1536 (0x600)

// Test biffVersion() for xlsx format (returns false for xlsx)
$bookXlsx = new ExcelBook(null, null, true);
$bookXlsx->addSheet('Test');
var_dump($bookXlsx->biffVersion());

// Test isDate1904() and setDate1904()
$book = new ExcelBook(null, null, true);
var_dump($book->isDate1904()); // Default should be false (1900 date system)

var_dump($book->setDate1904(true)); // Switch to 1904 date system
var_dump($book->isDate1904()); // Should be true now

var_dump($book->setDate1904(false)); // Switch back to 1900 date system
var_dump($book->isDate1904()); // Should be false

// Test getRefR1C1() and setRefR1C1()
var_dump($book->getRefR1C1()); // Default should be false

$book->setRefR1C1(true);
var_dump($book->getRefR1C1()); // Should be true now

$book->setRefR1C1(false);
var_dump($book->getRefR1C1()); // Should be false

// Test picture methods with embedded picture
$pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
$pictureId = $book->addPictureFromString($pngData);
var_dump($pictureId !== false);

// Test getNumPictures()
var_dump($book->getNumPictures());

// Test getPicture()
$picture = $book->getPicture(0);
var_dump(is_array($picture));
var_dump(isset($picture['data']));
var_dump(isset($picture['type']));
var_dump($picture['type'] === ExcelBook::PICTURETYPE_PNG);

// Test load() - save to string and reload
$sheet = $book->addSheet('LoadTest');
$sheet->write(0, 0, 'Test Data');
$sheet->write(1, 0, 12345);

$data = $book->save(); // Save to string
var_dump(is_string($data));
var_dump(strlen($data) > 0);

// Create new book and load from string
$book2 = new ExcelBook(null, null, true);
var_dump($book2->load($data));

// Verify data was loaded correctly
$sheet2 = $book2->getSheet(0); // First sheet (LoadTest)
var_dump($sheet2 !== false);
var_dump($sheet2->name());
var_dump($sheet2->read(0, 0));
var_dump($sheet2->read(1, 0));

// Test PICTURETYPE constants
var_dump(ExcelBook::PICTURETYPE_PNG);
var_dump(ExcelBook::PICTURETYPE_JPEG);
var_dump(ExcelBook::PICTURETYPE_WMF);
var_dump(ExcelBook::PICTURETYPE_DIB);
var_dump(ExcelBook::PICTURETYPE_EMF);
var_dump(ExcelBook::PICTURETYPE_PICT);
var_dump(ExcelBook::PICTURETYPE_TIFF);

// Test SCOPE constants
var_dump(ExcelBook::SCOPE_UNDEFINED);
var_dump(ExcelBook::SCOPE_WORKBOOK);

// Test SHEETTYPE constants
var_dump(ExcelBook::SHEETTYPE_SHEET);
var_dump(ExcelBook::SHEETTYPE_CHART);
var_dump(ExcelBook::SHEETTYPE_UNKNOWN);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(false)
bool(false)
bool(true)
bool(true)
bool(true)
bool(false)
bool(false)
bool(true)
bool(false)
bool(true)
int(1)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
string(8) "LoadTest"
string(9) "Test Data"
float(12345)
int(0)
int(1)
int(3)
int(4)
int(5)
int(6)
int(7)
int(-2)
int(-1)
int(0)
int(1)
int(2)
OK
