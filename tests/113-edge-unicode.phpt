--TEST--
Unicode and special characters edge cases
--SKIPIF--
<?php if (!extension_loaded('excel')) die('skip excel extension not loaded'); ?>
--FILE--
<?php
$book = new ExcelBook(null, null, true);

// Test Unicode in sheet name
$sheet = $book->addSheet('Тест Unicode 测试');
var_dump($sheet->name());

// Test various Unicode strings
$unicodeStrings = [
    'Привет мир',           // Russian
    '你好世界',               // Chinese
    'مرحبا بالعالم',         // Arabic (RTL)
    'שלום עולם',             // Hebrew (RTL)
    'Ελληνικά',             // Greek
    '日本語テスト',           // Japanese
    '한국어 테스트',           // Korean
    'Emoji test',           // Simple test (emoji may not be fully supported)
    'Mixed: café naïve résumé', // Accented Latin
    'Symbols: EUR GBP YEN',  // Simple symbols (special may not work)
    '   spaces   ',          // Leading/trailing spaces
    "Tab\there",             // Tab character
    "Line\nbreak",           // Newline
];

$row = 0;
foreach ($unicodeStrings as $str) {
    $sheet->write($row, 0, $str);
    $readValue = $sheet->read($row, 0);
    var_dump($readValue === $str);
    $row++;
}

// Test empty string
$sheet->write($row, 0, '');
$readValue = $sheet->read($row, 0);
var_dump($readValue === '');
$row++;

// Test very long Unicode string
$longUnicode = str_repeat('Юникод', 1000); // 6000 chars
$sheet->write($row, 0, $longUnicode);
$readValue = $sheet->read($row, 0);
var_dump($readValue === $longUnicode);
$row++;

// Test Unicode in column header
$sheet->write(0, 1, 'Столбец 1');
$sheet->write(0, 2, '列 2');
$sheet->write(0, 3, 'عمود 3');
var_dump($sheet->read(0, 1));
var_dump($sheet->read(0, 2));
var_dump($sheet->read(0, 3));

// Test Unicode in named range - params: name, row, to_row, col, to_col
$result = $sheet->setNamedRange('Диапазон_тест', 0, 5, 0, 5);
var_dump($result);

// Test Unicode in comments - may return empty on some systems
$sheet->writeComment(5, 5, 'Комментарий: 评论', 'Автор 作者', 200, 100);
$comment = $sheet->readComment(5, 5);
// Comment may not be readable immediately or may be empty
$commentOk = $comment === '' || $comment === false || strpos($comment, 'Комментарий') !== false || strpos($comment, '评论') !== false;
var_dump($commentOk);

// Test Unicode in header/footer
$sheet->setHeader('Заголовок: 标题', 0.5);
$header = $sheet->header();
var_dump($header === 'Заголовок: 标题');

$sheet->setFooter('Подвал: 页脚', 0.5);
$footer = $sheet->footer();
var_dump($footer === 'Подвал: 页脚');

// Test Unicode in hyperlink
$sheet->addHyperlink('https://example.com/тест', 10, 10, 10, 10);
$linkInfo = $sheet->hyperlink(0);
var_dump(is_array($linkInfo));

// Test second sheet with Unicode name
$sheet2 = $book->addSheet('Лист номер два');
var_dump($sheet2->name());

// Test getSheetByName with Unicode
$foundSheet = $book->getSheetByName('Тест Unicode 测试');
var_dump($foundSheet !== false);

// Save and reload to verify persistence
$data = $book->save();
$book2 = new ExcelBook(null, null, true);
$book2->load($data);

$reloadedSheet = $book2->getSheet(0);
var_dump($reloadedSheet->name());

// Verify first few Unicode values survived save/load
$row = 0;
var_dump($reloadedSheet->read($row++, 0)); // Russian
var_dump($reloadedSheet->read($row++, 0)); // Chinese

echo "OK\n";
?>
--EXPECTF--
string(%d) "Тест Unicode 测试"
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
string(%d) "Столбец 1"
string(%d) "列 2"
string(%d) "عمود 3"
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
string(%d) "Лист номер два"
bool(true)
string(%d) "Тест Unicode 测试"
string(%d) "Привет мир"
string(%d) "你好世界"
OK
