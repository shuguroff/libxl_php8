--TEST--
ExcelSheet methods for LibXL 3.8.0+ (data validation)
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!defined('LIBXL_VERSION') || LIBXL_VERSION < 0x03080000) die('skip LibXL 3.8.0+ required');
?>
--FILE--
<?php
// Create xlsx book (data validation only works with xlsx)
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('DataValidation Test');

// Test addDataValidation() with string values (whole number between 1-100)
$result = $sheet->addDataValidation(
    ExcelSheet::VALIDATION_TYPE_WHOLE,
    ExcelSheet::VALIDATION_OP_BETWEEN,
    0, 0, // row_first, row_last
    0, 0, // col_first, col_last
    '1',  // val_1
    '100' // val_2
);
var_dump($result);

// Test addDataValidation() with list
$result = $sheet->addDataValidation(
    ExcelSheet::VALIDATION_TYPE_LIST,
    ExcelSheet::VALIDATION_OP_BETWEEN,
    1, 1,
    0, 0,
    'Option1,Option2,Option3',
    null,
    true,  // allow_blank
    false, // hide_dropdown
    true,  // show_inputmessage
    true,  // show_errormessage
    'Input Title', // prompt_title
    'Please select an option', // prompt
    'Error Title', // error_title
    'Invalid selection', // error
    ExcelSheet::VALIDATION_ERRSTYLE_STOP
);
var_dump($result);

// Test addDataValidation() with text length
$result = $sheet->addDataValidation(
    ExcelSheet::VALIDATION_TYPE_TEXTLENGTH,
    ExcelSheet::VALIDATION_OP_LESSTHANOREQUAL,
    2, 2,
    0, 0,
    '50',
    null
);
var_dump($result);

// Test addDataValidationDouble() with decimal values
$result = $sheet->addDataValidationDouble(
    ExcelSheet::VALIDATION_TYPE_DECIMAL,
    ExcelSheet::VALIDATION_OP_BETWEEN,
    3, 3,
    0, 0,
    0.0,  // val_1 (double)
    100.5 // val_2 (double)
);
var_dump($result);

// Test addDataValidationDouble() with date values (Excel serial date)
// Date: 2024-01-01 = 45292, 2024-12-31 = 45657
$result = $sheet->addDataValidationDouble(
    ExcelSheet::VALIDATION_TYPE_DATE,
    ExcelSheet::VALIDATION_OP_BETWEEN,
    4, 4,
    0, 0,
    45292.0, // 2024-01-01
    45657.0, // 2024-12-31
    true,
    false,
    true,
    true,
    'Date Input',
    'Enter a date in 2024',
    'Invalid Date',
    'Please enter a date in 2024',
    ExcelSheet::VALIDATION_ERRSTYLE_WARNING
);
var_dump($result);

// Test removeDataValidations()
var_dump($sheet->removeDataValidations());

// Test VALIDATION_TYPE_* constants
var_dump(ExcelSheet::VALIDATION_TYPE_NONE);
var_dump(ExcelSheet::VALIDATION_TYPE_WHOLE);
var_dump(ExcelSheet::VALIDATION_TYPE_DECIMAL);
var_dump(ExcelSheet::VALIDATION_TYPE_LIST);
var_dump(ExcelSheet::VALIDATION_TYPE_DATE);
var_dump(ExcelSheet::VALIDATION_TYPE_TIME);
var_dump(ExcelSheet::VALIDATION_TYPE_TEXTLENGTH);
var_dump(ExcelSheet::VALIDATION_TYPE_CUSTOM);

// Test VALIDATION_OP_* constants
var_dump(ExcelSheet::VALIDATION_OP_BETWEEN);
var_dump(ExcelSheet::VALIDATION_OP_NOTBETWEEN);
var_dump(ExcelSheet::VALIDATION_OP_EQUAL);
var_dump(ExcelSheet::VALIDATION_OP_NOTEQUAL);
var_dump(ExcelSheet::VALIDATION_OP_LESSTHAN);
var_dump(ExcelSheet::VALIDATION_OP_LESSTHANOREQUAL);
var_dump(ExcelSheet::VALIDATION_OP_GREATERTHAN);
var_dump(ExcelSheet::VALIDATION_OP_GREATERTHANOREQUAL);

// Test VALIDATION_ERRSTYLE_* constants
var_dump(ExcelSheet::VALIDATION_ERRSTYLE_STOP);
var_dump(ExcelSheet::VALIDATION_ERRSTYLE_WARNING);
var_dump(ExcelSheet::VALIDATION_ERRSTYLE_INFORMATION);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(0)
int(1)
int(2)
int(3)
int(4)
int(5)
int(6)
int(7)
int(0)
int(1)
int(2)
int(3)
int(4)
int(5)
int(6)
int(7)
int(0)
int(1)
int(2)
OK
