--TEST--
ExcelConditionalFormatting: class registration, method existence and constants
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (!class_exists('ExcelConditionalFormatting')) die('skip ExcelConditionalFormatting not available (LibXL < 4.1.0)');
?>
--FILE--
<?php
$methods = [
    'addRange',
    'addRule',
    'addTopRule',
    'addOpNumRule',
    'addOpStrRule',
    'addAboveAverageRule',
    'addTimePeriodRule',
    'add2ColorScaleRule',
    'add2ColorScaleFormulaRule',
    'add3ColorScaleRule',
    'add3ColorScaleFormulaRule',
];

$allExist = true;
foreach ($methods as $method) {
    if (!method_exists('ExcelConditionalFormatting', $method)) {
        echo "MISSING method: $method\n";
        $allExist = false;
    }
}
var_dump($allExist);
var_dump(count($methods));

// Check CFormatType constants
$cformatConstants = [
    'CFORMAT_BEGINWITH', 'CFORMAT_CONTAINSBLANKS', 'CFORMAT_CONTAINSERRORS',
    'CFORMAT_CONTAINSTEXT', 'CFORMAT_DUPLICATEVALUES', 'CFORMAT_ENDSWITH',
    'CFORMAT_EXPRESSION', 'CFORMAT_NOTCONTAINSBLANKS', 'CFORMAT_NOTCONTAINSERRORS',
    'CFORMAT_NOTCONTAINSTEXT', 'CFORMAT_UNIQUEVALUES',
];

// Check CFormatOperator constants
$cfopConstants = [
    'CFOPERATOR_LESSTHAN', 'CFOPERATOR_LESSTHANOREQUAL', 'CFOPERATOR_EQUAL',
    'CFOPERATOR_NOTEQUAL', 'CFOPERATOR_GREATERTHANOREQUAL', 'CFOPERATOR_GREATERTHAN',
    'CFOPERATOR_BETWEEN', 'CFOPERATOR_NOTBETWEEN', 'CFOPERATOR_CONTAINSTEXT',
    'CFOPERATOR_NOTCONTAINS', 'CFOPERATOR_BEGINSWITH', 'CFOPERATOR_ENDSWITH',
];

// Check CFormatTimePeriod constants
$cftpConstants = [
    'CFTP_LAST7DAYS', 'CFTP_LASTMONTH', 'CFTP_LASTWEEK',
    'CFTP_NEXTMONTH', 'CFTP_NEXTWEEK', 'CFTP_THISMONTH',
    'CFTP_THISWEEK', 'CFTP_TODAY', 'CFTP_TOMORROW', 'CFTP_YESTERDAY',
];

// Check CFVOType constants
$cfvoConstants = [
    'CFVO_MIN', 'CFVO_MAX', 'CFVO_FORMULA',
    'CFVO_NUMBER', 'CFVO_PERCENT', 'CFVO_PERCENTILE',
];

$rc = new ReflectionClass('ExcelConditionalFormatting');
$allConsts = true;
$allConstants = array_merge($cformatConstants, $cfopConstants, $cftpConstants, $cfvoConstants);
foreach ($allConstants as $const) {
    if (!$rc->hasConstant($const)) {
        echo "MISSING constant: $const\n";
        $allConsts = false;
    }
}
var_dump($allConsts);
var_dump(count($allConstants));

// Cannot instantiate directly
try {
    new ExcelConditionalFormatting();
} catch (\Exception $e) {
    echo "caught\n";
}

echo "OK\n";
?>
--EXPECT--
bool(true)
int(11)
bool(true)
int(39)
caught
OK
