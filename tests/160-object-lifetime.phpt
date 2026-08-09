--TEST--
Child objects keep ExcelBook alive and reject stale LibXL handles
--SKIPIF--
<?php
if (!extension_loaded('excel')) die('skip excel extension not loaded');
if (LIBXL_VERSION < 0x05010000) die('skip requires LibXL >= 5.1.0');
?>
--FILE--
<?php
function expectStale($object, $method)
{
    try {
        $object->$method();
        echo "not stale\n";
    } catch (ExcelException $e) {
        echo "stale\n";
    }
}

// A child must keep its native owner alive.
$book = new ExcelBook(null, null, true);
$bookRef = WeakReference::create($book);
$sheet = $book->addSheet('Owned');
unset($book);
gc_collect_cycles();
var_dump($bookRef->get() instanceof ExcelBook);
var_dump($sheet->write(0, 0, 'ok'));
unset($sheet);
gc_collect_cycles();
var_dump($bookRef->get() === null);

// Clones must copy the owner reference.
$book = new ExcelBook(null, null, true);
$bookRef = WeakReference::create($book);
$format = clone $book->addFormat();
unset($book);
gc_collect_cycles();
var_dump($bookRef->get() instanceof ExcelBook);
var_dump(is_int($format->numberFormat()));
unset($format);
gc_collect_cycles();
var_dump($bookRef->get() === null);

// The hidden owner reference must remain visible to cycle collection.
$book = new ExcelBook(null, null, true);
$bookRef = WeakReference::create($book);
@$book->sheet = $book->addSheet('Cycle');
unset($book);
gc_collect_cycles();
var_dump($bookRef->get() === null);

// Workbook-wide mutations invalidate old wrappers but not newly fetched ones.
$book = new ExcelBook(null, null, true);
$oldSheet = $book->addSheet('BeforeLoad');
$data = $book->save();
var_dump($book->load($data));
expectStale($oldSheet, 'name');
$sheet = $book->getSheet(0);
var_dump($sheet->name());

$book->clear();
expectStale($sheet, 'name');
$sheet = $book->addSheet('AfterClear');
var_dump($sheet->name());

$other = $book->addSheet('Other');
var_dump($book->deleteSheet(1));
expectStale($sheet, 'name');
expectStale($other, 'name');
var_dump($book->getSheet(0)->name());
?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
stale
string(10) "BeforeLoad"
stale
string(10) "AfterClear"
bool(true)
stale
stale
string(10) "AfterClear"
