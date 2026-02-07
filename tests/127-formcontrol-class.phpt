--TEST--
ExcelFormControl class: constants and direct instantiation check
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelFormControl')) die('skip ExcelFormControl not available (LibXL < 4.0.0)');
?>
--FILE--
<?php
// Class exists
var_dump(class_exists('ExcelFormControl'));

// ObjectType constants
var_dump(ExcelFormControl::OBJECT_UNKNOWN === 0);
var_dump(ExcelFormControl::OBJECT_BUTTON === 1);
var_dump(ExcelFormControl::OBJECT_CHECKBOX === 2);
var_dump(ExcelFormControl::OBJECT_DROP === 3);
var_dump(ExcelFormControl::OBJECT_GBOX === 4);
var_dump(ExcelFormControl::OBJECT_LABEL === 5);
var_dump(ExcelFormControl::OBJECT_LIST === 6);
var_dump(ExcelFormControl::OBJECT_RADIO === 7);
var_dump(ExcelFormControl::OBJECT_SCROLL === 8);
var_dump(ExcelFormControl::OBJECT_SPIN === 9);
var_dump(ExcelFormControl::OBJECT_EDITBOX === 10);
var_dump(ExcelFormControl::OBJECT_DIALOG === 11);

// CheckedType constants
var_dump(ExcelFormControl::CHECKEDTYPE_UNCHECKED === 0);
var_dump(ExcelFormControl::CHECKEDTYPE_CHECKED === 1);
var_dump(ExcelFormControl::CHECKEDTYPE_MIXED === 2);

// Cannot be instantiated directly
try {
    $fc = new ExcelFormControl();
    echo "ERROR: should have thrown\n";
} catch (ExcelException $e) {
    var_dump(true);
}

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
OK
