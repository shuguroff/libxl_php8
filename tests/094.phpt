--TEST--
Sheet::addDataValidation()
--SKIPIF--
<?php if (!extension_loaded("excel") || !in_array('addDataValidation', get_class_methods('ExcelSheet'))) print "skip"; ?>
--FILE--
<?php
	$book = new ExcelBook(null, null, true);
	$sheet = new ExcelSheet($book, 'sheet');

	try {
		var_dump(
			$sheet->addDataValidation(
				\ExcelSheet::VALIDATION_TYPE_WHOLE,
				\ExcelSheet::VALIDATION_OP_BETWEEN,
				1,
				2,
				1,
				2,
				'1'
			)
		);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}

	var_dump(
		$sheet->addDataValidation(
			\ExcelSheet::VALIDATION_TYPE_WHOLE,
			\ExcelSheet::VALIDATION_OP_BETWEEN,
			1,
			2,
			1,
			2,
			'1',
			'3'
		)
	);

	var_dump(
		$sheet->addDataValidation(
			\ExcelSheet::VALIDATION_TYPE_WHOLE,
			\ExcelSheet::VALIDATION_OP_BETWEEN,
			1,
			2,
			1,
			2,
			'1',
			'100',
			1,
			0,
			1,
			1,
			'Prompt_Title',
			'Prompt',
			'Error Title',
			'Error'
		)
	);

	try {
		var_dump(
			$sheet->addDataValidationDouble(
				\ExcelSheet::VALIDATION_TYPE_WHOLE,
				\ExcelSheet::VALIDATION_OP_BETWEEN,
				1,
				2,
				1,
				2,
				'1'
			)
		);
	} catch (ExcelException $e) {
		echo "EXCEPTION: " . $e->getMessage() . "\n";
		var_dump(false);
	}

	var_dump(
		$sheet->addDataValidationDouble(
			\ExcelSheet::VALIDATION_TYPE_WHOLE,
			\ExcelSheet::VALIDATION_OP_BETWEEN,
			1,
			2,
			1,
			2,
			1,
			2,
			1,
			0,
			1,
			3,
			'Prompt_Title',
			'Prompt',
			'Error Title',
			'Error'
		)
	);

	var_dump(
		$sheet->addDataValidation(
			\ExcelSheet::VALIDATION_TYPE_WHOLE,
			\ExcelSheet::VALIDATION_OP_EQUAL,
			1,
			2,
			1,
			2,
			'1'
		)
	);

	var_dump(
		$sheet->removeDataValidations()
	);

	echo "OK\n";

?>
--EXPECTF--
EXCEPTION: The second value cannot be null when used with (not) between operator
bool(false)
bool(true)
bool(true)
EXCEPTION: The second value cannot be null when used with (not) between operator
bool(false)
bool(true)
bool(true)
bool(true)
OK
