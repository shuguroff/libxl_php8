--TEST--
ExcelSheet methods for LibXL 3.7.0+
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03070000) die('skip LibXL 3.7.0+ required');
?>
--FILE--
<?php
// Create xlsx book
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Sheet 3.7.0 Test');

// Test setTabColor() - set tab color to red
var_dump($sheet->setTabColor(ExcelFormat::COLOR_RED));

// Write some data
$sheet->write(0, 0, 'Header');
$sheet->write(1, 0, 100);
$sheet->write(2, 0, 200);

// Test autoFilter() - returns ExcelAutoFilter object
$autoFilter = $sheet->autoFilter();
var_dump($autoFilter instanceof ExcelAutoFilter);

// Set autofilter range
$autoFilter->setRef(0, 0, 2, 0);

// Test applyFilter()
var_dump($sheet->applyFilter());

// Test removeFilter()
var_dump($sheet->removeFilter());

// Test writeError() - write Excel error value
$sheet->write(3, 0, 'Test');
var_dump($sheet->writeError(4, 0, ExcelSheet::ERRORTYPE_DIV_0));

// Test writeError with format
$format = $book->addFormat();
var_dump($sheet->writeError(5, 0, ExcelSheet::ERRORTYPE_NA, $format));

// Test addIgnoredError() - ignore specific error type for range
var_dump($sheet->addIgnoredError(ExcelSheet::IERR_NUMBER_STORED_AS_TEXT, 0, 0, 5, 0));

// Test tableSize() - should be 0 for new sheet
var_dump($sheet->tableSize());

// Test IERR_* constants exist
var_dump(ExcelSheet::IERR_EVAL_ERROR);
var_dump(ExcelSheet::IERR_EMPTY_CELLREF);
var_dump(ExcelSheet::IERR_NUMBER_STORED_AS_TEXT);
var_dump(ExcelSheet::IERR_INCONSIST_RANGE);
var_dump(ExcelSheet::IERR_INCONSIST_FMLA);
var_dump(ExcelSheet::IERR_TWODIG_TEXTYEAR);
var_dump(ExcelSheet::IERR_UNLOCK_FMLA);
var_dump(ExcelSheet::IERR_DATA_VALIDATION);

// Test PROT_* constants exist (enhanced protection)
var_dump(ExcelSheet::PROT_DEFAULT);
var_dump(ExcelSheet::PROT_ALL);
var_dump(ExcelSheet::PROT_OBJECTS);
var_dump(ExcelSheet::PROT_AUTOFILTER);

// Test setProtect with enhanced protection
$sheet->setProtect(true, 'password123', ExcelSheet::PROT_ALL);
var_dump($sheet->protect());

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(0)
int(1)
int(2)
int(4)
int(8)
int(16)
int(32)
int(64)
int(128)
int(-1)
int(0)
int(1)
int(4096)
bool(true)
OK
