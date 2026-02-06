--TEST--
Column Read
--INI--
date.timezone=America/Toronto
--SKIPIF--
<?php if (!extension_loaded("excel")) print "skip"; ?>
--FILE--
<?php 
	$x = new ExcelBook();

	$s = $x->addSheet("Sheet 1");

	$data = array(true, 1.222, 434324, "fsdfasDF", NULL, "", false, -3321, -77.3321, "a a a a a aa");

	for ($i = 0; $i < 10; $i++) {
		for ($j = 0; $j < 10; $j++) {
			$s->write($j, $i, $data[$j]);
		}
	}

	var_dump($s->readCol(2), $x->getError());
	var_dump($s->readCol(2, 4), $x->getError());	
	var_dump($s->readCol(2, 5, 5), $x->getError());

	try {
		var_dump($s->readCol(-2));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	try {
		var_dump($s->readCol(22));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	try {
		var_dump($s->readCol(2, -1));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	try {
		var_dump($s->readCol(2, 55));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	try {
		var_dump($s->readCol(2, 2, 1));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	try {
		var_dump($s->readCol(2, 2, 39));
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}
	
	echo "OK\n";
?>
--EXPECTF--
array(10) {
  [0]=>
  bool(true)
  [1]=>
  float(1.222)
  [2]=>
  float(434324)
  [3]=>
  string(8) "fsdfasDF"
  [4]=>
  NULL
  [5]=>
  string(0) ""
  [6]=>
  bool(false)
  [7]=>
  float(-3321)
  [8]=>
  float(-77.3321)
  [9]=>
  string(12) "a a a a a aa"
}
bool(false)
array(6) {
  [0]=>
  NULL
  [1]=>
  string(0) ""
  [2]=>
  bool(false)
  [3]=>
  float(-3321)
  [4]=>
  float(-77.3321)
  [5]=>
  string(12) "a a a a a aa"
}
bool(false)
array(1) {
  [0]=>
  string(0) ""
}
bool(false)
EXCEPTION: Invalid column number '-2'
bool(false)
EXCEPTION: Invalid column number '22'
bool(false)
EXCEPTION: Invalid starting row number '-1'
bool(false)
EXCEPTION: Invalid starting row number '55'
bool(false)
EXCEPTION: Invalid ending row number '1'
bool(false)
EXCEPTION: Invalid ending row number '39'
bool(false)
OK
