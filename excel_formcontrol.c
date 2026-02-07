#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04000000

zend_class_entry *excel_ce_formcontrol;
zend_object_handlers excel_object_handlers_formcontrol;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_formcontrol_object_free_storage(zend_object *object)
{
	zend_object_std_dtor(object);
}

static zend_object *excel_object_new_formcontrol_ex(zend_class_entry *class_type, excel_formcontrol_object **ptr)
{
	excel_formcontrol_object *intern;

	intern = zend_object_alloc(sizeof(excel_formcontrol_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_formcontrol;

	return &intern->std;
}

zend_object *excel_object_new_formcontrol(zend_class_entry *class_type)
{
	return excel_object_new_formcontrol_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelFormControl::__construct()
   ---------------------------------------------------------------- */

/* {{{ proto ExcelFormControl ExcelFormControl::__construct()
	FormControl cannot be instantiated directly */
EXCEL_METHOD(FormControl, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelFormControl cannot be instantiated directly, use ExcelSheet::formControl()", 0);
	RETURN_THROWS();
}
/* }}} */

/* ----------------------------------------------------------------
   Type
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelFormControl::objectType()
	Returns the object type of the form control */
EXCEL_METHOD(FormControl, objectType)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlObjectType(formcontrol));
}
/* }}} */

/* ----------------------------------------------------------------
   Checkbox: checked / setChecked
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelFormControl::checked()
	Returns the checked state of the form control (CheckedType) */
EXCEL_METHOD(FormControl, checked)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlChecked(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setChecked(int checked)
	Sets the checked state of the form control */
EXCEL_METHOD(FormControl, setChecked)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long checked;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &checked) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetChecked(formcontrol, (int)checked);
}
/* }}} */

/* ----------------------------------------------------------------
   Formula pairs: fmlaGroup, fmlaLink, fmlaRange, fmlaTxbx
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelFormControl::fmlaGroup()
	Returns the group formula */
EXCEL_METHOD(FormControl, fmlaGroup)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlFmlaGroup(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelFormControl::setFmlaGroup(string group)
	Sets the group formula */
EXCEL_METHOD(FormControl, setFmlaGroup)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *group;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &group) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetFmlaGroup(formcontrol, ZSTR_VAL(group));
}
/* }}} */

/* {{{ proto string ExcelFormControl::fmlaLink()
	Returns the link formula */
EXCEL_METHOD(FormControl, fmlaLink)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlFmlaLink(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelFormControl::setFmlaLink(string link)
	Sets the link formula */
EXCEL_METHOD(FormControl, setFmlaLink)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *link;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &link) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetFmlaLink(formcontrol, ZSTR_VAL(link));
}
/* }}} */

/* {{{ proto string ExcelFormControl::fmlaRange()
	Returns the range formula */
EXCEL_METHOD(FormControl, fmlaRange)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlFmlaRange(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelFormControl::setFmlaRange(string range)
	Sets the range formula */
EXCEL_METHOD(FormControl, setFmlaRange)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *range;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &range) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetFmlaRange(formcontrol, ZSTR_VAL(range));
}
/* }}} */

/* {{{ proto string ExcelFormControl::fmlaTxbx()
	Returns the textbox formula */
EXCEL_METHOD(FormControl, fmlaTxbx)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlFmlaTxbx(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelFormControl::setFmlaTxbx(string txbx)
	Sets the textbox formula */
EXCEL_METHOD(FormControl, setFmlaTxbx)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *txbx;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &txbx) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetFmlaTxbx(formcontrol, ZSTR_VAL(txbx));
}
/* }}} */

/* ----------------------------------------------------------------
   Read-only string properties
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelFormControl::name()
	Returns the name of the form control */
EXCEL_METHOD(FormControl, name)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlName(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto string ExcelFormControl::linkedCell()
	Returns the linked cell */
EXCEL_METHOD(FormControl, linkedCell)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlLinkedCell(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto string ExcelFormControl::listFillRange()
	Returns the list fill range */
EXCEL_METHOD(FormControl, listFillRange)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlListFillRange(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto string ExcelFormControl::macro()
	Returns the macro name */
EXCEL_METHOD(FormControl, macro)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlMacro(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto string ExcelFormControl::altText()
	Returns the alt text */
EXCEL_METHOD(FormControl, altText)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlAltText(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* ----------------------------------------------------------------
   Read-only boolean properties
   ---------------------------------------------------------------- */

/* {{{ proto bool ExcelFormControl::locked()
	Returns whether the form control is locked */
EXCEL_METHOD(FormControl, locked)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_BOOL(xlFormControlLocked(formcontrol));
}
/* }}} */

/* {{{ proto bool ExcelFormControl::defaultSize()
	Returns whether the form control has default size */
EXCEL_METHOD(FormControl, defaultSize)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_BOOL(xlFormControlDefaultSize(formcontrol));
}
/* }}} */

/* {{{ proto bool ExcelFormControl::print()
	Returns whether the form control is printable */
EXCEL_METHOD(FormControl, print)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_BOOL(xlFormControlPrint(formcontrol));
}
/* }}} */

/* {{{ proto bool ExcelFormControl::disabled()
	Returns whether the form control is disabled */
EXCEL_METHOD(FormControl, disabled)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_BOOL(xlFormControlDisabled(formcontrol));
}
/* }}} */

/* ----------------------------------------------------------------
   List items: item, itemSize, addItem, insertItem, clearItems
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelFormControl::item(int index)
	Returns the list item at the specified index */
EXCEL_METHOD(FormControl, item)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long index;
	const char *result;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &index) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlItem(formcontrol, (int)index);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_FALSE;
}
/* }}} */

/* {{{ proto int ExcelFormControl::itemSize()
	Returns the number of list items */
EXCEL_METHOD(FormControl, itemSize)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlItemSize(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::addItem(string value)
	Adds an item to the list */
EXCEL_METHOD(FormControl, addItem)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *value;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &value) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlAddItem(formcontrol, ZSTR_VAL(value));
}
/* }}} */

/* {{{ proto void ExcelFormControl::insertItem(int index, string value)
	Inserts an item at the specified index */
EXCEL_METHOD(FormControl, insertItem)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long index;
	zend_string *value;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lS", &index, &value) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlInsertItem(formcontrol, (int)index, ZSTR_VAL(value));
}
/* }}} */

/* {{{ proto void ExcelFormControl::clearItems()
	Clears all list items */
EXCEL_METHOD(FormControl, clearItems)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlClearItems(formcontrol);
}
/* }}} */

/* ----------------------------------------------------------------
   Numeric get/set pairs
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelFormControl::dropLines()
	Returns the number of drop lines */
EXCEL_METHOD(FormControl, dropLines)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlDropLines(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setDropLines(int lines)
	Sets the number of drop lines */
EXCEL_METHOD(FormControl, setDropLines)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long lines;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &lines) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetDropLines(formcontrol, (int)lines);
}
/* }}} */

/* {{{ proto int ExcelFormControl::dx()
	Returns the width (dx) value */
EXCEL_METHOD(FormControl, dx)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlDx(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setDx(int dx)
	Sets the width (dx) value */
EXCEL_METHOD(FormControl, setDx)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long dx;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &dx) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetDx(formcontrol, (int)dx);
}
/* }}} */

/* {{{ proto int ExcelFormControl::firstButton()
	Returns whether this is the first button in a group */
EXCEL_METHOD(FormControl, firstButton)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlFirstButton(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setFirstButton(int firstButton)
	Sets the first button flag */
EXCEL_METHOD(FormControl, setFirstButton)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long firstButton;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &firstButton) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetFirstButton(formcontrol, (int)firstButton);
}
/* }}} */

/* {{{ proto int ExcelFormControl::horiz()
	Returns the horizontal orientation flag */
EXCEL_METHOD(FormControl, horiz)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlHoriz(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setHoriz(int horiz)
	Sets the horizontal orientation flag */
EXCEL_METHOD(FormControl, setHoriz)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long horiz;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &horiz) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetHoriz(formcontrol, (int)horiz);
}
/* }}} */

/* {{{ proto int ExcelFormControl::inc()
	Returns the increment value */
EXCEL_METHOD(FormControl, inc)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlInc(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setInc(int inc)
	Sets the increment value */
EXCEL_METHOD(FormControl, setInc)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long inc;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &inc) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetInc(formcontrol, (int)inc);
}
/* }}} */

/* {{{ proto int ExcelFormControl::getMax()
	Returns the maximum value */
EXCEL_METHOD(FormControl, getMax)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlGetMax(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setMax(int max)
	Sets the maximum value */
EXCEL_METHOD(FormControl, setMax)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long max;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &max) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetMax(formcontrol, (int)max);
}
/* }}} */

/* {{{ proto int ExcelFormControl::getMin()
	Returns the minimum value */
EXCEL_METHOD(FormControl, getMin)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlGetMin(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setMin(int min)
	Sets the minimum value */
EXCEL_METHOD(FormControl, setMin)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long min;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &min) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetMin(formcontrol, (int)min);
}
/* }}} */

/* {{{ proto int ExcelFormControl::sel()
	Returns the selected item index */
EXCEL_METHOD(FormControl, sel)
{
	FormControlHandle formcontrol;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	RETURN_LONG(xlFormControlSel(formcontrol));
}
/* }}} */

/* {{{ proto void ExcelFormControl::setSel(int sel)
	Sets the selected item index */
EXCEL_METHOD(FormControl, setSel)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_long sel;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &sel) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetSel(formcontrol, (int)sel);
}
/* }}} */

/* ----------------------------------------------------------------
   String get/set: multiSel
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelFormControl::multiSel()
	Returns the multi-select value */
EXCEL_METHOD(FormControl, multiSel)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	const char *result;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	result = xlFormControlMultiSel(formcontrol);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelFormControl::setMultiSel(string value)
	Sets the multi-select value */
EXCEL_METHOD(FormControl, setMultiSel)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	zend_string *value;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &value) == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	xlFormControlSetMultiSel(formcontrol, ZSTR_VAL(value));
}
/* }}} */

/* ----------------------------------------------------------------
   Anchors: fromAnchor, toAnchor
   ---------------------------------------------------------------- */

/* {{{ proto array ExcelFormControl::fromAnchor()
	Returns the starting anchor position as array {col, colOff, row, rowOff} */
EXCEL_METHOD(FormControl, fromAnchor)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	int col, colOff, row, rowOff;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	if (!xlFormControlFromAnchor(formcontrol, &col, &colOff, &row, &rowOff)) {
		RETURN_FALSE;
	}

	array_init(return_value);
	add_assoc_long(return_value, "col", col);
	add_assoc_long(return_value, "colOff", colOff);
	add_assoc_long(return_value, "row", row);
	add_assoc_long(return_value, "rowOff", rowOff);
}
/* }}} */

/* {{{ proto array ExcelFormControl::toAnchor()
	Returns the ending anchor position as array {col, colOff, row, rowOff} */
EXCEL_METHOD(FormControl, toAnchor)
{
	FormControlHandle formcontrol;
	zval *object = getThis();
	int col, colOff, row, rowOff;

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	FORMCONTROL_FROM_OBJECT(formcontrol, object);

	if (!xlFormControlToAnchor(formcontrol, &col, &colOff, &row, &rowOff)) {
		RETURN_FALSE;
	}

	array_init(return_value);
	add_assoc_long(return_value, "col", col);
	add_assoc_long(return_value, "colOff", colOff);
	add_assoc_long(return_value, "row", row);
	add_assoc_long(return_value, "rowOff", rowOff);
}
/* }}} */

/* ----------------------------------------------------------------
   Arginfo
   ---------------------------------------------------------------- */

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_void, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_setChecked, 0, 0, 1)
	ZEND_ARG_INFO(0, checked)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_setString, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_setInt, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_item, 0, 0, 1)
	ZEND_ARG_INFO(0, index)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_FormControl_insertItem, 0, 0, 2)
	ZEND_ARG_INFO(0, index)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

/* ----------------------------------------------------------------
   Method entry table
   ---------------------------------------------------------------- */

static zend_function_entry excel_funcs_formcontrol[] = {
	EXCEL_ME(FormControl, __construct, arginfo_FormControl___construct, ZEND_ACC_PUBLIC|ZEND_ACC_FINAL)
	/* Type */
	EXCEL_ME(FormControl, objectType, arginfo_FormControl_void, 0)
	/* Checkbox */
	EXCEL_ME(FormControl, checked, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setChecked, arginfo_FormControl_setChecked, 0)
	/* Formulas */
	EXCEL_ME(FormControl, fmlaGroup, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setFmlaGroup, arginfo_FormControl_setString, 0)
	EXCEL_ME(FormControl, fmlaLink, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setFmlaLink, arginfo_FormControl_setString, 0)
	EXCEL_ME(FormControl, fmlaRange, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setFmlaRange, arginfo_FormControl_setString, 0)
	EXCEL_ME(FormControl, fmlaTxbx, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setFmlaTxbx, arginfo_FormControl_setString, 0)
	/* Read-only strings */
	EXCEL_ME(FormControl, name, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, linkedCell, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, listFillRange, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, macro, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, altText, arginfo_FormControl_void, 0)
	/* Read-only booleans */
	EXCEL_ME(FormControl, locked, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, defaultSize, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, print, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, disabled, arginfo_FormControl_void, 0)
	/* List items */
	EXCEL_ME(FormControl, item, arginfo_FormControl_item, 0)
	EXCEL_ME(FormControl, itemSize, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, addItem, arginfo_FormControl_setString, 0)
	EXCEL_ME(FormControl, insertItem, arginfo_FormControl_insertItem, 0)
	EXCEL_ME(FormControl, clearItems, arginfo_FormControl_void, 0)
	/* Numeric get/set */
	EXCEL_ME(FormControl, dropLines, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setDropLines, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, dx, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setDx, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, firstButton, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setFirstButton, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, horiz, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setHoriz, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, inc, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setInc, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, getMax, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setMax, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, getMin, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setMin, arginfo_FormControl_setInt, 0)
	EXCEL_ME(FormControl, sel, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setSel, arginfo_FormControl_setInt, 0)
	/* String get/set */
	EXCEL_ME(FormControl, multiSel, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, setMultiSel, arginfo_FormControl_setString, 0)
	/* Anchors */
	EXCEL_ME(FormControl, fromAnchor, arginfo_FormControl_void, 0)
	EXCEL_ME(FormControl, toAnchor, arginfo_FormControl_void, 0)
	PHP_FE_END
};

/* ----------------------------------------------------------------
   Class registration
   ---------------------------------------------------------------- */

void excel_formcontrol_register(void)
{
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "ExcelFormControl", excel_funcs_formcontrol);
	ce.create_object = excel_object_new_formcontrol;
	excel_ce_formcontrol = zend_register_internal_class_ex(&ce, NULL);
	memcpy(&excel_object_handlers_formcontrol, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_formcontrol.offset = XtOffsetOf(excel_formcontrol_object, std);
	excel_object_handlers_formcontrol.free_obj = excel_formcontrol_object_free_storage;
	excel_object_handlers_formcontrol.clone_obj = NULL;

	/* ObjectType constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_UNKNOWN", OBJECT_UNKNOWN);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_BUTTON", OBJECT_BUTTON);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_CHECKBOX", OBJECT_CHECKBOX);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_DROP", OBJECT_DROP);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_GBOX", OBJECT_GBOX);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_LABEL", OBJECT_LABEL);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_LIST", OBJECT_LIST);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_RADIO", OBJECT_RADIO);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_SCROLL", OBJECT_SCROLL);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_SPIN", OBJECT_SPIN);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_EDITBOX", OBJECT_EDITBOX);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "OBJECT_DIALOG", OBJECT_DIALOG);

	/* CheckedType constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "CHECKEDTYPE_UNCHECKED", CHECKEDTYPE_UNCHECKED);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "CHECKEDTYPE_CHECKED", CHECKEDTYPE_CHECKED);
	REGISTER_EXCEL_CLASS_CONST_LONG(formcontrol, "CHECKEDTYPE_MIXED", CHECKEDTYPE_MIXED);
}

#else

void excel_formcontrol_register(void)
{
	/* noop: LibXL < 4.0.0 */
}

#endif
