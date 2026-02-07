--TEST--
ExcelConditionalFormat: class registration and method existence
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelConditionalFormat')) die('skip ExcelConditionalFormat not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$methods = [
    'font',
    'numFormat', 'setNumFormat',
    'customNumFormat', 'setCustomNumFormat',
    'setBorder', 'setBorderColor',
    'borderLeft', 'setBorderLeft',
    'borderRight', 'setBorderRight',
    'borderTop', 'setBorderTop',
    'borderBottom', 'setBorderBottom',
    'borderLeftColor', 'setBorderLeftColor',
    'borderRightColor', 'setBorderRightColor',
    'borderTopColor', 'setBorderTopColor',
    'borderBottomColor', 'setBorderBottomColor',
    'fillPattern', 'setFillPattern',
    'patternForegroundColor', 'setPatternForegroundColor',
    'patternBackgroundColor', 'setPatternBackgroundColor',
];

$allExist = true;
foreach ($methods as $method) {
    if (!method_exists('ExcelConditionalFormat', $method)) {
        echo "MISSING: $method\n";
        $allExist = false;
    }
}
var_dump($allExist);
var_dump(count($methods));

// Cannot instantiate directly
try {
    new ExcelConditionalFormat();
} catch (\Exception $e) {
    echo "caught\n";
}

echo "OK\n";
?>
--EXPECT--
bool(true)
int(29)
caught
OK
