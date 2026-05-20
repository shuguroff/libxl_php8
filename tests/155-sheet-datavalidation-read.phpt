--TEST--
ExcelSheet::dataValidationSize() and dataValidation()
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!method_exists('ExcelSheet', 'dataValidation')) die('skip ExcelSheet::dataValidation() not available (LibXL < 5.2.0)');
?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);
$sheet = $book->addSheet('Validations');

$sheet->write(0, 0, 'Qty');
$sheet->write(0, 1, 'Ratio');

$sheet->addDataValidation(
    ExcelSheet::VALIDATION_TYPE_WHOLE,
    ExcelSheet::VALIDATION_OP_BETWEEN,
    1, 3, 0, 0,
    '1', '10',
    true, false, true, true,
    'Quantity', 'Enter 1-10', 'Invalid quantity', 'Use a whole number from 1 to 10',
    ExcelSheet::VALIDATION_ERRSTYLE_WARNING
);

$sheet->addDataValidationDouble(
    ExcelSheet::VALIDATION_TYPE_DECIMAL,
    ExcelSheet::VALIDATION_OP_GREATERTHAN,
    1, 3, 1, 1,
    2.5,
    0.0,
    false, false, false, true,
    '', '', 'Invalid ratio', 'Use a value greater than 2.5',
    ExcelSheet::VALIDATION_ERRSTYLE_STOP
);

$file = tempnam(sys_get_temp_dir(), 'libxl_dv_') . '.xlsx';
$book->save($file);

$book2 = new ExcelBook(null, null, true);
var_dump($book2->loadFile($file));
$sheet2 = $book2->getSheet(0);

var_dump(is_int($sheet2->dataValidationSize()));

$dv0 = $sheet2->dataValidation(0);
var_dump(is_array($dv0));
var_dump($dv0['type'] === ExcelSheet::VALIDATION_TYPE_WHOLE);
var_dump($dv0['op'] === ExcelSheet::VALIDATION_OP_BETWEEN);
var_dump($dv0['row_first']);
var_dump($dv0['row_last']);
var_dump($dv0['col_first']);
var_dump($dv0['col_last']);
var_dump($dv0['value_1']);
var_dump($dv0['value_2']);
var_dump($dv0['allow_blank']);
var_dump($dv0['hide_dropdown']);
var_dump($dv0['show_inputmessage']);
var_dump($dv0['show_errormessage']);
var_dump($dv0['prompt_title']);
var_dump($dv0['prompt']);
var_dump($dv0['error_title']);
var_dump($dv0['error']);
var_dump($dv0['error_style'] === ExcelSheet::VALIDATION_ERRSTYLE_WARNING);

$dv1 = $sheet2->dataValidation(1);
var_dump(is_array($dv1));
var_dump($dv1['type'] === ExcelSheet::VALIDATION_TYPE_DECIMAL);
var_dump($dv1['op'] === ExcelSheet::VALIDATION_OP_GREATERTHAN);
var_dump($dv1['row_first']);
var_dump($dv1['row_last']);
var_dump($dv1['col_first']);
var_dump($dv1['col_last']);
var_dump($dv1['value_1'] !== '');
var_dump($dv1['allow_blank']);
var_dump($dv1['show_inputmessage']);
var_dump($dv1['show_errormessage']);
var_dump($dv1['error_title']);
var_dump($dv1['error']);
var_dump($dv1['error_style'] === ExcelSheet::VALIDATION_ERRSTYLE_STOP);

var_dump($sheet2->dataValidation(99));
@unlink($file);

echo "OK\n";
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
int(1)
int(3)
int(0)
int(0)
string(1) "1"
string(2) "10"
bool(true)
bool(false)
bool(true)
bool(true)
string(8) "Quantity"
string(10) "Enter 1-10"
string(16) "Invalid quantity"
string(31) "Use a whole number from 1 to 10"
bool(true)
bool(true)
bool(true)
bool(true)
int(1)
int(3)
int(1)
int(1)
bool(true)
bool(false)
bool(false)
bool(true)
string(13) "Invalid ratio"
string(28) "Use a value greater than 2.5"
bool(true)
bool(false)
OK
