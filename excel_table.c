#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04060000

/* ================================================================
   ExcelTable
   ================================================================ */

zend_class_entry *excel_ce_table;
zend_object_handlers excel_object_handlers_table;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_table_object_free_storage(zend_object *object)
{
	zend_object_std_dtor(object);
}

static zend_object *excel_object_new_table_ex(zend_class_entry *class_type, excel_table_object **ptr)
{
	excel_table_object *intern;

	intern = zend_object_alloc(sizeof(excel_table_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_table;

	return &intern->std;
}

zend_object *excel_object_new_table(zend_class_entry *class_type)
{
	return excel_object_new_table_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelTable::__construct()
   ---------------------------------------------------------------- */

EXCEL_METHOD(Table, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelTable cannot be instantiated directly, use ExcelSheet::addTable()", 0);
	RETURN_THROWS();
}

/* ----------------------------------------------------------------
   ExcelTable::name()
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelTable::name()
	Returns the table name. */
EXCEL_METHOD(Table, name)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);

	const char *val = xlTableName(table);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelTable::setName(string name)
	Sets the table name. */
EXCEL_METHOD(Table, setName)
{
	TableHandle table;
	zval *object = getThis();
	zend_string *name;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &name) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetName(table, ZSTR_VAL(name));
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::ref()
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelTable::ref()
	Returns the table reference. */
EXCEL_METHOD(Table, ref)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);

	const char *val = xlTableRef(table);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelTable::setRef(string ref)
	Sets the table reference. */
EXCEL_METHOD(Table, setRef)
{
	TableHandle table;
	zval *object = getThis();
	zend_string *ref;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &ref) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetRef(table, ZSTR_VAL(ref));
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::autoFilter()
   ---------------------------------------------------------------- */

/* {{{ proto ExcelAutoFilter ExcelTable::autoFilter()
	Returns the auto filter of the table. */
EXCEL_METHOD(Table, autoFilter)
{
	TableHandle table;
	SheetHandle sheet;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_AND_SHEET_FROM_OBJECT(table, sheet, object);

	AutoFilterHandle af = xlTableAutoFilter(table);
	if (!af) {
		RETURN_FALSE;
	}

	ZVAL_OBJ(return_value, excel_object_new_autofilter(excel_ce_autofilter));
	excel_autofilter_object *afo = Z_EXCEL_AUTOFILTER_OBJ_P(return_value);
	afo->autofilter = af;
	afo->sheet = sheet;
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::style() / setStyle()
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelTable::style()
	Returns the table style. */
EXCEL_METHOD(Table, style)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_LONG(xlTableStyle(table));
}
/* }}} */

/* {{{ proto void ExcelTable::setStyle(int tableStyle)
	Sets the table style. */
EXCEL_METHOD(Table, setStyle)
{
	TableHandle table;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetStyle(table, (int)style);
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::showRowStripes() / setShowRowStripes()
   ---------------------------------------------------------------- */

/* {{{ proto bool ExcelTable::showRowStripes()
	Returns whether row stripes are shown. */
EXCEL_METHOD(Table, showRowStripes)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_BOOL(xlTableShowRowStripes(table));
}
/* }}} */

/* {{{ proto void ExcelTable::setShowRowStripes(bool show)
	Sets whether row stripes are shown. */
EXCEL_METHOD(Table, setShowRowStripes)
{
	TableHandle table;
	zval *object = getThis();
	zend_bool show;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "b", &show) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetShowRowStripes(table, (int)show);
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::showColumnStripes() / setShowColumnStripes()
   ---------------------------------------------------------------- */

/* {{{ proto bool ExcelTable::showColumnStripes()
	Returns whether column stripes are shown. */
EXCEL_METHOD(Table, showColumnStripes)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_BOOL(xlTableShowColumnStripes(table));
}
/* }}} */

/* {{{ proto void ExcelTable::setShowColumnStripes(bool show)
	Sets whether column stripes are shown. */
EXCEL_METHOD(Table, setShowColumnStripes)
{
	TableHandle table;
	zval *object = getThis();
	zend_bool show;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "b", &show) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetShowColumnStripes(table, (int)show);
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::showFirstColumn() / setShowFirstColumn()
   ---------------------------------------------------------------- */

/* {{{ proto bool ExcelTable::showFirstColumn()
	Returns whether the first column is highlighted. */
EXCEL_METHOD(Table, showFirstColumn)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_BOOL(xlTableShowFirstColumn(table));
}
/* }}} */

/* {{{ proto void ExcelTable::setShowFirstColumn(bool show)
	Sets whether the first column is highlighted. */
EXCEL_METHOD(Table, setShowFirstColumn)
{
	TableHandle table;
	zval *object = getThis();
	zend_bool show;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "b", &show) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetShowFirstColumn(table, (int)show);
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::showLastColumn() / setShowLastColumn()
   ---------------------------------------------------------------- */

/* {{{ proto bool ExcelTable::showLastColumn()
	Returns whether the last column is highlighted. */
EXCEL_METHOD(Table, showLastColumn)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_BOOL(xlTableShowLastColumn(table));
}
/* }}} */

/* {{{ proto void ExcelTable::setShowLastColumn(bool show)
	Sets whether the last column is highlighted. */
EXCEL_METHOD(Table, setShowLastColumn)
{
	TableHandle table;
	zval *object = getThis();
	zend_bool show;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "b", &show) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	xlTableSetShowLastColumn(table, (int)show);
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::columnSize()
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelTable::columnSize()
	Returns the number of columns in the table. */
EXCEL_METHOD(Table, columnSize)
{
	TableHandle table;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);
	RETURN_LONG(xlTableColumnSize(table));
}
/* }}} */

/* ----------------------------------------------------------------
   ExcelTable::columnName() / setColumnName()
   ---------------------------------------------------------------- */

/* {{{ proto string|false ExcelTable::columnName(int columnIndex)
	Returns the column name at the specified index. */
EXCEL_METHOD(Table, columnName)
{
	TableHandle table;
	zval *object = getThis();
	zend_long index;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &index) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);

	const char *val = xlTableColumnName(table, (int)index);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_FALSE;
}
/* }}} */

/* {{{ proto bool ExcelTable::setColumnName(int columnIndex, string name)
	Sets the column name at the specified index. */
EXCEL_METHOD(Table, setColumnName)
{
	TableHandle table;
	zval *object = getThis();
	zend_long index;
	zend_string *name;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lS", &index, &name) == FAILURE) {
		RETURN_THROWS();
	}

	TABLE_FROM_OBJECT(table, object);

	if (!xlTableSetColumnName(table, (int)index, ZSTR_VAL(name))) {
		RETURN_FALSE;
	}
	RETURN_TRUE;
}
/* }}} */

/* ================================================================
   Arginfo
   ================================================================ */

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_noargs, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_setString, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_setStyle, 0, 0, 1)
	ZEND_ARG_INFO(0, tableStyle)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_setBool, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_columnName, 0, 0, 1)
	ZEND_ARG_INFO(0, columnIndex)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_Table_setColumnName, 0, 0, 2)
	ZEND_ARG_INFO(0, columnIndex)
	ZEND_ARG_INFO(0, name)
ZEND_END_ARG_INFO()

/* ================================================================
   Method entries
   ================================================================ */

zend_function_entry excel_funcs_table[] = {
	EXCEL_ME(Table, __construct, arginfo_Table___construct, 0)
	EXCEL_ME(Table, name, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setName, arginfo_Table_setString, 0)
	EXCEL_ME(Table, ref, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setRef, arginfo_Table_setString, 0)
	EXCEL_ME(Table, autoFilter, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, style, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setStyle, arginfo_Table_setStyle, 0)
	EXCEL_ME(Table, showRowStripes, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setShowRowStripes, arginfo_Table_setBool, 0)
	EXCEL_ME(Table, showColumnStripes, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setShowColumnStripes, arginfo_Table_setBool, 0)
	EXCEL_ME(Table, showFirstColumn, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setShowFirstColumn, arginfo_Table_setBool, 0)
	EXCEL_ME(Table, showLastColumn, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, setShowLastColumn, arginfo_Table_setBool, 0)
	EXCEL_ME(Table, columnSize, arginfo_Table_noargs, 0)
	EXCEL_ME(Table, columnName, arginfo_Table_columnName, 0)
	EXCEL_ME(Table, setColumnName, arginfo_Table_setColumnName, 0)
	PHP_FE_END
};

/* ================================================================
   Class registration
   ================================================================ */

void excel_table_register(void)
{
	zend_class_entry ce;

	INIT_CLASS_ENTRY(ce, "ExcelTable", excel_funcs_table);
	excel_ce_table = zend_register_internal_class_ex(&ce, NULL);
	excel_ce_table->ce_flags |= ZEND_ACC_FINAL;
	excel_ce_table->create_object = excel_object_new_table;

	memcpy(&excel_object_handlers_table, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_table.offset = XtOffsetOf(excel_table_object, std);
	excel_object_handlers_table.free_obj = excel_table_object_free_storage;
	excel_object_handlers_table.clone_obj = NULL;

	/* TableStyle constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_NONE", TABLESTYLE_NONE);

	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT1", TABLESTYLE_LIGHT1);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT2", TABLESTYLE_LIGHT2);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT3", TABLESTYLE_LIGHT3);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT4", TABLESTYLE_LIGHT4);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT5", TABLESTYLE_LIGHT5);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT6", TABLESTYLE_LIGHT6);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT7", TABLESTYLE_LIGHT7);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT8", TABLESTYLE_LIGHT8);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT9", TABLESTYLE_LIGHT9);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT10", TABLESTYLE_LIGHT10);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT11", TABLESTYLE_LIGHT11);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT12", TABLESTYLE_LIGHT12);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT13", TABLESTYLE_LIGHT13);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT14", TABLESTYLE_LIGHT14);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT15", TABLESTYLE_LIGHT15);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT16", TABLESTYLE_LIGHT16);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT17", TABLESTYLE_LIGHT17);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT18", TABLESTYLE_LIGHT18);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT19", TABLESTYLE_LIGHT19);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT20", TABLESTYLE_LIGHT20);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_LIGHT21", TABLESTYLE_LIGHT21);

	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM1", TABLESTYLE_MEDIUM1);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM2", TABLESTYLE_MEDIUM2);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM3", TABLESTYLE_MEDIUM3);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM4", TABLESTYLE_MEDIUM4);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM5", TABLESTYLE_MEDIUM5);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM6", TABLESTYLE_MEDIUM6);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM7", TABLESTYLE_MEDIUM7);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM8", TABLESTYLE_MEDIUM8);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM9", TABLESTYLE_MEDIUM9);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM10", TABLESTYLE_MEDIUM10);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM11", TABLESTYLE_MEDIUM11);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM12", TABLESTYLE_MEDIUM12);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM13", TABLESTYLE_MEDIUM13);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM14", TABLESTYLE_MEDIUM14);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM15", TABLESTYLE_MEDIUM15);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM16", TABLESTYLE_MEDIUM16);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM17", TABLESTYLE_MEDIUM17);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM18", TABLESTYLE_MEDIUM18);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM19", TABLESTYLE_MEDIUM19);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM20", TABLESTYLE_MEDIUM20);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM21", TABLESTYLE_MEDIUM21);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM22", TABLESTYLE_MEDIUM22);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM23", TABLESTYLE_MEDIUM23);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM24", TABLESTYLE_MEDIUM24);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM25", TABLESTYLE_MEDIUM25);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM26", TABLESTYLE_MEDIUM26);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM27", TABLESTYLE_MEDIUM27);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_MEDIUM28", TABLESTYLE_MEDIUM28);

	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK1", TABLESTYLE_DARK1);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK2", TABLESTYLE_DARK2);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK3", TABLESTYLE_DARK3);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK4", TABLESTYLE_DARK4);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK5", TABLESTYLE_DARK5);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK6", TABLESTYLE_DARK6);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK7", TABLESTYLE_DARK7);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK8", TABLESTYLE_DARK8);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK9", TABLESTYLE_DARK9);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK10", TABLESTYLE_DARK10);
	REGISTER_EXCEL_CLASS_CONST_LONG(table, "TABLESTYLE_DARK11", TABLESTYLE_DARK11);
}

#else

void excel_table_register(void)
{
	/* noop: LibXL < 4.6.0 */
}

#endif
