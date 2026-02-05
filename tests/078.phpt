--TEST--
Sheet::colHidden(), Sheet::rowHidden(), Sheet::setColHidden() and Sheet::setRowHidden()
--SKIPIF--
<?php if (!extension_loaded("excel") || !in_array('rowHidden', get_class_methods('ExcelSheet'))) print "skip"; ?>
--FILE--
<?php
$book = new ExcelBook();

$sheet = $book->addSheet('Sheet 1');

// Test basic functionality
var_dump(
    $sheet->rowHidden(0),
    $sheet->colHidden(0)
);

// Test ArgumentCountError in PHP 8
try {
    $sheet->setRowHidden(1);
} catch (Throwable $e) {
    echo "setRowHidden error: " . get_class($e) . "\n";
}

try {
    $sheet->setColHidden(1);
} catch (Throwable $e) {
    echo "setColHidden error: " . get_class($e) . "\n";
}

// Test setting hidden
var_dump(
    $sheet->setRowHidden(1, true),
    $sheet->setRowHidden(2, true),
    $sheet->setColHidden(1, true),
    $sheet->setColHidden(2, true),
    $sheet->rowHidden(1),
    $sheet->colHidden(1),
    $sheet->rowHidden(0),
    $sheet->colHidden(0),
    $sheet->setRowHidden(1, false),
    $sheet->setColHidden(1, false),
    $sheet->rowHidden(1),
    $sheet->colHidden(1)
);
?>
--EXPECT--
bool(false)
bool(false)
setRowHidden error: ArgumentCountError
setColHidden error: ArgumentCountError
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(false)
bool(false)
bool(true)
bool(true)
bool(false)
bool(false)
