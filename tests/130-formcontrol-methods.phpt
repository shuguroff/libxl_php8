--TEST--
ExcelFormControl: verify all methods exist
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelFormControl')) die('skip ExcelFormControl not available (LibXL < 4.0.0)');
?>
--FILE--
<?php
$methods = [
    // Type
    'objectType',
    // Checkbox
    'checked', 'setChecked',
    // Formulas
    'fmlaGroup', 'setFmlaGroup',
    'fmlaLink', 'setFmlaLink',
    'fmlaRange', 'setFmlaRange',
    'fmlaTxbx', 'setFmlaTxbx',
    // Read-only strings
    'name', 'linkedCell', 'listFillRange', 'macro', 'altText',
    // Read-only booleans
    'locked', 'defaultSize', 'print', 'disabled',
    // List items
    'item', 'itemSize', 'addItem', 'insertItem', 'clearItems',
    // Numeric get/set
    'dropLines', 'setDropLines',
    'dx', 'setDx',
    'firstButton', 'setFirstButton',
    'horiz', 'setHoriz',
    'inc', 'setInc',
    'getMax', 'setMax',
    'getMin', 'setMin',
    'sel', 'setSel',
    // String get/set
    'multiSel', 'setMultiSel',
    // Anchors
    'fromAnchor', 'toAnchor',
];

$allExist = true;
foreach ($methods as $method) {
    if (!method_exists('ExcelFormControl', $method)) {
        echo "MISSING: $method\n";
        $allExist = false;
    }
}
var_dump($allExist);
var_dump(count($methods)); // 45 methods (excluding __construct)

echo "OK\n";
?>
--EXPECT--
bool(true)
int(45)
OK
