<?php
$book = new ExcelBook(null, null, true);

// version() returns an integer > 0
$ver = $book->version();
var_dump(is_int($ver));
var_dump($ver > 0);

// isWriteProtected() returns bool
$wp = $book->isWriteProtected();
var_dump(is_bool($wp));
var_dump($wp === false); // new book is not write-protected

// loadWithoutEmptyCells() with non-existing file should return false
$result = $book->loadWithoutEmptyCells('/tmp/nonexistent_' . uniqid() . '.xlsx');
var_dump($result === false);

// loadWithoutEmptyCells() with valid file
$book2 = new ExcelBook(null, null, true);
$sheet = $book2->addSheet('Test');
$sheet->write(0, 0, 'Hello');
$sheet->write(5, 5, 'World');
$tmpfile = tempnam(sys_get_temp_dir(), 'xltest_') . '.xlsx';
$book2->save($tmpfile);

$book3 = new ExcelBook(null, null, true);
$result = $book3->loadWithoutEmptyCells($tmpfile);
var_dump($result === true);

echo "OK\n";
?>
