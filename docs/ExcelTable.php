<?php

/**
 * ExcelTable class (requires LibXL >= 4.6.0)
 *
 * Represents a table (ListObject) in an Excel sheet.
 * Cannot be instantiated directly — use ExcelSheet::addTable().
 */
final class ExcelTable
{
    /* TableStyle constants */
    const TABLESTYLE_NONE = 0;

    const TABLESTYLE_LIGHT1 = 1;
    const TABLESTYLE_LIGHT2 = 2;
    const TABLESTYLE_LIGHT3 = 3;
    const TABLESTYLE_LIGHT4 = 4;
    const TABLESTYLE_LIGHT5 = 5;
    const TABLESTYLE_LIGHT6 = 6;
    const TABLESTYLE_LIGHT7 = 7;
    const TABLESTYLE_LIGHT8 = 8;
    const TABLESTYLE_LIGHT9 = 9;
    const TABLESTYLE_LIGHT10 = 10;
    const TABLESTYLE_LIGHT11 = 11;
    const TABLESTYLE_LIGHT12 = 12;
    const TABLESTYLE_LIGHT13 = 13;
    const TABLESTYLE_LIGHT14 = 14;
    const TABLESTYLE_LIGHT15 = 15;
    const TABLESTYLE_LIGHT16 = 16;
    const TABLESTYLE_LIGHT17 = 17;
    const TABLESTYLE_LIGHT18 = 18;
    const TABLESTYLE_LIGHT19 = 19;
    const TABLESTYLE_LIGHT20 = 20;
    const TABLESTYLE_LIGHT21 = 21;

    const TABLESTYLE_MEDIUM1 = 22;
    const TABLESTYLE_MEDIUM2 = 23;
    const TABLESTYLE_MEDIUM3 = 24;
    const TABLESTYLE_MEDIUM4 = 25;
    const TABLESTYLE_MEDIUM5 = 26;
    const TABLESTYLE_MEDIUM6 = 27;
    const TABLESTYLE_MEDIUM7 = 28;
    const TABLESTYLE_MEDIUM8 = 29;
    const TABLESTYLE_MEDIUM9 = 30;
    const TABLESTYLE_MEDIUM10 = 31;
    const TABLESTYLE_MEDIUM11 = 32;
    const TABLESTYLE_MEDIUM12 = 33;
    const TABLESTYLE_MEDIUM13 = 34;
    const TABLESTYLE_MEDIUM14 = 35;
    const TABLESTYLE_MEDIUM15 = 36;
    const TABLESTYLE_MEDIUM16 = 37;
    const TABLESTYLE_MEDIUM17 = 38;
    const TABLESTYLE_MEDIUM18 = 39;
    const TABLESTYLE_MEDIUM19 = 40;
    const TABLESTYLE_MEDIUM20 = 41;
    const TABLESTYLE_MEDIUM21 = 42;
    const TABLESTYLE_MEDIUM22 = 43;
    const TABLESTYLE_MEDIUM23 = 44;
    const TABLESTYLE_MEDIUM24 = 45;
    const TABLESTYLE_MEDIUM25 = 46;
    const TABLESTYLE_MEDIUM26 = 47;
    const TABLESTYLE_MEDIUM27 = 48;
    const TABLESTYLE_MEDIUM28 = 49;

    const TABLESTYLE_DARK1 = 50;
    const TABLESTYLE_DARK2 = 51;
    const TABLESTYLE_DARK3 = 52;
    const TABLESTYLE_DARK4 = 53;
    const TABLESTYLE_DARK5 = 54;
    const TABLESTYLE_DARK6 = 55;
    const TABLESTYLE_DARK7 = 56;
    const TABLESTYLE_DARK8 = 57;
    const TABLESTYLE_DARK9 = 58;
    const TABLESTYLE_DARK10 = 59;
    const TABLESTYLE_DARK11 = 60;

    /**
     * @throws ExcelException Cannot be instantiated directly
     */
    public function __construct() {}

    /**
     * Returns the table name.
     * @return string
     */
    public function name(): string {}

    /**
     * Sets the table name.
     * @param string $name
     * @return void
     */
    public function setName(string $name): void {}

    /**
     * Returns the table reference (e.g. "A1:D10").
     * @return string
     */
    public function ref(): string {}

    /**
     * Sets the table reference.
     * @param string $ref
     * @return void
     */
    public function setRef(string $ref): void {}

    /**
     * Returns the auto filter of the table.
     * @return ExcelAutoFilter|false
     */
    public function autoFilter(): ExcelAutoFilter|false {}

    /**
     * Returns the table style (one of TABLESTYLE_* constants).
     * @return int
     */
    public function style(): int {}

    /**
     * Sets the table style.
     * @param int $tableStyle One of TABLESTYLE_* constants
     * @return void
     */
    public function setStyle(int $tableStyle): void {}

    /**
     * Returns whether row stripes are shown.
     * @return bool
     */
    public function showRowStripes(): bool {}

    /**
     * Sets whether row stripes are shown.
     * @param bool $show
     * @return void
     */
    public function setShowRowStripes(bool $show): void {}

    /**
     * Returns whether column stripes are shown.
     * @return bool
     */
    public function showColumnStripes(): bool {}

    /**
     * Sets whether column stripes are shown.
     * @param bool $show
     * @return void
     */
    public function setShowColumnStripes(bool $show): void {}

    /**
     * Returns whether the first column is highlighted.
     * @return bool
     */
    public function showFirstColumn(): bool {}

    /**
     * Sets whether the first column is highlighted.
     * @param bool $show
     * @return void
     */
    public function setShowFirstColumn(bool $show): void {}

    /**
     * Returns whether the last column is highlighted.
     * @return bool
     */
    public function showLastColumn(): bool {}

    /**
     * Sets whether the last column is highlighted.
     * @param bool $show
     * @return void
     */
    public function setShowLastColumn(bool $show): void {}

    /**
     * Returns the number of columns in the table.
     * @return int
     */
    public function columnSize(): int {}

    /**
     * Returns the column name at the specified index.
     * @param int $columnIndex
     * @return string|false
     */
    public function columnName(int $columnIndex): string|false {}

    /**
     * Sets the column name at the specified index.
     * @param int $columnIndex
     * @param string $name
     * @return bool
     */
    public function setColumnName(int $columnIndex, string $name): bool {}
}
