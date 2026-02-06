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

	var_dump($x->packDateValues(2013, 10, 12, 1, 10, 30));

	try {
		$x->packDateValues(-1, 10, 12, 1, 10, 30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);

	try {
		$x->packDateValues(2013, -10, 12, 1, 10, 30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);

	try {
		$x->packDateValues(2013, 10, -12, 1, 10, 30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);

	try {
		$x->packDateValues(2013, 10, 12, -1, 10, 30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);

	try {
		$x->packDateValues(2013, 10, 12, 1, -10, 30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);

	try {
		$x->packDateValues(2013, 10, 12, 1, 10, -30);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
	}
	var_dump(false);
?>
--EXPECTF--
Error: ArgumentCountError
float(41559.048958333%s)
EXCEPTION: Invalid '-1' value for year
bool(false)
EXCEPTION: Invalid '-10' value for month
bool(false)
EXCEPTION: Invalid '-12' value for day
bool(false)
EXCEPTION: Invalid '-1' value for hour
bool(false)
EXCEPTION: Invalid '-10' value for minute
bool(false)
EXCEPTION: Invalid '-30' value for second
bool(false)
