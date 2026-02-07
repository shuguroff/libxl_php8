--TEST--
ExcelCoreProperties: string properties (title, subject, creator, etc.)
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelCoreProperties')) die('skip ExcelCoreProperties not available (LibXL < 4.5.0)');
?>
--FILE--
<?php
$tmpFile = tempnam(sys_get_temp_dir(), 'xltest') . '.xlsx';

$book = new ExcelBook(null, null, true); // XLSX
$sheet = $book->addSheet('Test');
$sheet->write(0, 0, 'hello');

$cp = $book->coreProperties();
var_dump($cp instanceof ExcelCoreProperties);

// Set string properties
$cp->setTitle('Test Title');
$cp->setSubject('Test Subject');
$cp->setCreator('Test Creator');
$cp->setLastModifiedBy('Test Modifier');
$cp->setTags('tag1, tag2');
$cp->setCategories('cat1');
$cp->setComments('Test comment');

// Read back
var_dump($cp->title());
var_dump($cp->subject());
var_dump($cp->creator());
var_dump($cp->lastModifiedBy());
var_dump($cp->tags());
var_dump($cp->categories());
var_dump($cp->comments());

// Save and reload
$book->save($tmpFile);

$book2 = new ExcelBook(null, null, true);
$book2->loadFile($tmpFile);
$cp2 = $book2->coreProperties();

var_dump($cp2->title());
var_dump($cp2->subject());
var_dump($cp2->creator());

@unlink($tmpFile);

echo "OK\n";
?>
--EXPECT--
bool(true)
string(10) "Test Title"
string(12) "Test Subject"
string(12) "Test Creator"
string(13) "Test Modifier"
string(10) "tag1, tag2"
string(4) "cat1"
string(12) "Test comment"
string(10) "Test Title"
string(12) "Test Subject"
string(12) "Test Creator"
OK
