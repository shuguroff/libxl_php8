--TEST--
Font constructor test
--INI--
date.timezone=America/Toronto
--SKIPIF--
<?php if (!extension_loaded("excel")) print "skip"; ?>
--FILE--
<?php
	$x = new ExcelBook();

	try {
		$format = new ExcelFont();
	} catch (Throwable $e) {
		var_dump($e->getMessage());
	}

	try {
		$format = new ExcelFont('cdsd');
	} catch (Throwable $e) {
		var_dump($e->getMessage());
	}
	echo "OK\n"
?>
--EXPECTF--
string(%d) "ExcelFont::__construct() expects exactly 1 %s, 0 given"
string(%d) "%sExcelBook, string given"
OK
