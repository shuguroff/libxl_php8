--TEST--
Book::getPhpExcelVersion()
--SKIPIF--
<?php if (!extension_loaded("excel") || !in_array('getPhpExcelVersion', get_class_methods('ExcelBook'))) print "skip"; ?>
--FILE--
<?php
$book = new ExcelBook();

$version = $book->getPhpExcelVersion();
var_dump(
    preg_match('/^\d+\.\d+\.\d+$/', $version) === 1,
    $version === phpversion('excel')
);

?>
--EXPECT--
bool(true)
bool(true)
