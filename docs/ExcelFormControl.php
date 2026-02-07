<?php
/**
 * ExcelFormControl class — represents a form control on a sheet.
 *
 * Requires LibXL >= 4.0.0. Cannot be instantiated directly;
 * use ExcelSheet::formControl() to obtain an instance.
 */
class ExcelFormControl
{
    /* ObjectType constants */
    const OBJECT_UNKNOWN = 0;
    const OBJECT_BUTTON = 1;
    const OBJECT_CHECKBOX = 2;
    const OBJECT_DROP = 3;
    const OBJECT_GBOX = 4;
    const OBJECT_LABEL = 5;
    const OBJECT_LIST = 6;
    const OBJECT_RADIO = 7;
    const OBJECT_SCROLL = 8;
    const OBJECT_SPIN = 9;
    const OBJECT_EDITBOX = 10;
    const OBJECT_DIALOG = 11;

    /* CheckedType constants */
    const CHECKEDTYPE_UNCHECKED = 0;
    const CHECKEDTYPE_CHECKED = 1;
    const CHECKEDTYPE_MIXED = 2;

    /**
     * Returns the object type (ObjectType constant).
     * @return int
     */
    public function objectType() {}

    /**
     * Returns the checked state (CheckedType constant).
     * @return int
     */
    public function checked() {}

    /**
     * Sets the checked state.
     * @param int $checked CheckedType constant
     * @return void
     */
    public function setChecked(int $checked) {}

    /**
     * Returns the group formula.
     * @return string
     */
    public function fmlaGroup() {}

    /**
     * Sets the group formula.
     * @param string $group
     * @return void
     */
    public function setFmlaGroup(string $group) {}

    /**
     * Returns the link formula.
     * @return string
     */
    public function fmlaLink() {}

    /**
     * Sets the link formula.
     * @param string $link
     * @return void
     */
    public function setFmlaLink(string $link) {}

    /**
     * Returns the range formula.
     * @return string
     */
    public function fmlaRange() {}

    /**
     * Sets the range formula.
     * @param string $range
     * @return void
     */
    public function setFmlaRange(string $range) {}

    /**
     * Returns the textbox formula.
     * @return string
     */
    public function fmlaTxbx() {}

    /**
     * Sets the textbox formula.
     * @param string $txbx
     * @return void
     */
    public function setFmlaTxbx(string $txbx) {}

    /**
     * Returns the name of the form control.
     * @return string
     */
    public function name() {}

    /**
     * Returns the linked cell.
     * @return string
     */
    public function linkedCell() {}

    /**
     * Returns the list fill range.
     * @return string
     */
    public function listFillRange() {}

    /**
     * Returns the macro name.
     * @return string
     */
    public function macro() {}

    /**
     * Returns the alt text.
     * @return string
     */
    public function altText() {}

    /**
     * Returns whether the form control is locked.
     * @return bool
     */
    public function locked() {}

    /**
     * Returns whether the form control has default size.
     * @return bool
     */
    public function defaultSize() {}

    /**
     * Returns whether the form control is printable.
     * @return bool
     */
    public function print() {}

    /**
     * Returns whether the form control is disabled.
     * @return bool
     */
    public function disabled() {}

    /**
     * Returns the list item at the specified index.
     * @param int $index
     * @return string|false
     */
    public function item(int $index) {}

    /**
     * Returns the number of list items.
     * @return int
     */
    public function itemSize() {}

    /**
     * Adds an item to the list.
     * @param string $value
     * @return void
     */
    public function addItem(string $value) {}

    /**
     * Inserts an item at the specified index.
     * @param int $index
     * @param string $value
     * @return void
     */
    public function insertItem(int $index, string $value) {}

    /**
     * Clears all list items.
     * @return void
     */
    public function clearItems() {}

    /**
     * Returns the number of drop lines.
     * @return int
     */
    public function dropLines() {}

    /**
     * Sets the number of drop lines.
     * @param int $lines
     * @return void
     */
    public function setDropLines(int $lines) {}

    /**
     * Returns the width (dx) value.
     * @return int
     */
    public function dx() {}

    /**
     * Sets the width (dx) value.
     * @param int $dx
     * @return void
     */
    public function setDx(int $dx) {}

    /**
     * Returns the first button flag.
     * @return int
     */
    public function firstButton() {}

    /**
     * Sets the first button flag.
     * @param int $firstButton
     * @return void
     */
    public function setFirstButton(int $firstButton) {}

    /**
     * Returns the horizontal orientation flag.
     * @return int
     */
    public function horiz() {}

    /**
     * Sets the horizontal orientation flag.
     * @param int $horiz
     * @return void
     */
    public function setHoriz(int $horiz) {}

    /**
     * Returns the increment value.
     * @return int
     */
    public function inc() {}

    /**
     * Sets the increment value.
     * @param int $inc
     * @return void
     */
    public function setInc(int $inc) {}

    /**
     * Returns the maximum value.
     * @return int
     */
    public function getMax() {}

    /**
     * Sets the maximum value.
     * @param int $max
     * @return void
     */
    public function setMax(int $max) {}

    /**
     * Returns the minimum value.
     * @return int
     */
    public function getMin() {}

    /**
     * Sets the minimum value.
     * @param int $min
     * @return void
     */
    public function setMin(int $min) {}

    /**
     * Returns the selected item index.
     * @return int
     */
    public function sel() {}

    /**
     * Sets the selected item index.
     * @param int $sel
     * @return void
     */
    public function setSel(int $sel) {}

    /**
     * Returns the multi-select value.
     * @return string
     */
    public function multiSel() {}

    /**
     * Sets the multi-select value.
     * @param string $value
     * @return void
     */
    public function setMultiSel(string $value) {}

    /**
     * Returns the starting anchor position.
     * @return array{col: int, colOff: int, row: int, rowOff: int}|false
     */
    public function fromAnchor() {}

    /**
     * Returns the ending anchor position.
     * @return array{col: int, colOff: int, row: int, rowOff: int}|false
     */
    public function toAnchor() {}
}
