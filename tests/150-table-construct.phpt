--TEST--
ExcelTable::__construct throws, constants check
--SKIPIF--
<?php if (!extension_loaded("excel")) die("skip excel ext missing"); if (!class_exists('ExcelTable')) die('skip LibXL < 4.6.0'); ?>
--FILE--
<?php

// __construct throws
try {
    new ExcelTable();
} catch (ExcelException $e) {
    echo $e->getMessage() . "\n";
}

// check a few constants exist
var_dump(ExcelTable::TABLESTYLE_NONE === 0);
var_dump(ExcelTable::TABLESTYLE_LIGHT1 === 1);
var_dump(ExcelTable::TABLESTYLE_LIGHT21 === 21);
var_dump(ExcelTable::TABLESTYLE_MEDIUM1 === 22);
var_dump(ExcelTable::TABLESTYLE_MEDIUM28 === 49);
var_dump(ExcelTable::TABLESTYLE_DARK1 === 50);
var_dump(ExcelTable::TABLESTYLE_DARK11 === 60);

echo "OK\n";
?>
--EXPECT--
ExcelTable cannot be instantiated directly, use ExcelSheet::addTable()
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
OK
