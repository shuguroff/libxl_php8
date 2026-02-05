--TEST--
Format constructor test
--INI--
date.timezone=America/Toronto
--SKIPIF--
<?php if (!extension_loaded("excel")) print "skip"; ?>
--FILE--
<?php
	$x = new ExcelBook();

	try {
		$format = new ExcelFormat();
	} catch (Throwable $e) {
		var_dump($e->getMessage());
	}

	try {
		$format = new ExcelFormat('cdsd');
	} catch (Throwable $e) {
		var_dump($e->getMessage());
	}

	echo "OK\n";
?>
--EXPECTF--
string(%d) "ExcelFormat::__construct() expects exactly 1 %s, 0 given"
string(%d) "%sExcelBook, string given"
OK
