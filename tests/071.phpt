--TEST--
Book::packDateValues()
--SKIPIF--
<?php if (!extension_loaded("excel") || !in_array('packDateValues', get_class_methods('ExcelBook'))) print "skip"; ?>
--FILE--
<?php
	$x = new ExcelBook();

	// Test missing arguments (ArgumentCountError in PHP 8)
	try {
		$x->packDateValues();
	} catch (Throwable $e) {
		echo "Error: " . get_class($e) . "\n";
	}

	var_dump(
		$x->packDateValues(2013, 10, 12, 1, 10, 30),
		$x->packDateValues(-1, 10, 12, 1, 10, 30),
		$x->packDateValues(2013, -10, 12, 1, 10, 30),
		$x->packDateValues(2013, 10, -12, 1, 10, 30),
		$x->packDateValues(2013, 10, 12, -1, 10, 30),
		$x->packDateValues(2013, 10, 12, 1, -10, 30),
		$x->packDateValues(2013, 10, 12, 1, 10, -30)
	);
?>
--EXPECTF--
Error: ArgumentCountError

Warning: ExcelBook::packDateValues(): Invalid '-1' value for year in %s on line %d

Warning: ExcelBook::packDateValues(): Invalid '-10' value for month in %s on line %d

Warning: ExcelBook::packDateValues(): Invalid '-12' value for day in %s on line %d

Warning: ExcelBook::packDateValues(): Invalid '-1' value for hour in %s on line %d

Warning: ExcelBook::packDateValues(): Invalid '-10' value for minute in %s on line %d

Warning: ExcelBook::packDateValues(): Invalid '-30' value for second in %s on line %d
float(41559.048958333%s)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)
