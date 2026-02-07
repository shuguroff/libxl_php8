#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04010000

/* ================================================================
   ExcelConditionalFormat
   ================================================================ */

zend_class_entry *excel_ce_condformat;
zend_object_handlers excel_object_handlers_condformat;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_condformat_object_free_storage(zend_object *object)
{
	zend_object_std_dtor(object);
}

static zend_object *excel_object_new_condformat_ex(zend_class_entry *class_type, excel_condformat_object **ptr)
{
	excel_condformat_object *intern;

	intern = zend_object_alloc(sizeof(excel_condformat_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_condformat;

	return &intern->std;
}

zend_object *excel_object_new_condformat(zend_class_entry *class_type)
{
	return excel_object_new_condformat_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelConditionalFormat::__construct()
   ---------------------------------------------------------------- */

EXCEL_METHOD(ConditionalFormat, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelConditionalFormat cannot be instantiated directly, use ExcelBook::addConditionalFormat()", 0);
	RETURN_THROWS();
}

/* ----------------------------------------------------------------
   Font
   ---------------------------------------------------------------- */

/* {{{ proto ExcelFont ExcelConditionalFormat::font()
	Returns the font for this conditional format */
EXCEL_METHOD(ConditionalFormat, font)
{
	ConditionalFormatHandle condformat;
	BookHandle book;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_AND_BOOK_FROM_OBJECT(condformat, book, object);

	FontHandle font = xlConditionalFormatFont(condformat);
	if (!font) {
		RETURN_FALSE;
	}

	ZVAL_OBJ(return_value, excel_object_new_font(excel_ce_font));
	excel_font_object *fo = Z_EXCEL_FONT_OBJ_P(return_value);
	fo->font = font;
	fo->book = book;
}
/* }}} */

/* ----------------------------------------------------------------
   Num format
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelConditionalFormat::numFormat()
	Returns the number format index */
EXCEL_METHOD(ConditionalFormat, numFormat)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatNumFormat(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setNumFormat(int numFormat)
	Sets the number format index */
EXCEL_METHOD(ConditionalFormat, setNumFormat)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long numFormat;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &numFormat) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetNumFormat(condformat, (int)numFormat);
}
/* }}} */

/* ----------------------------------------------------------------
   Custom num format
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelConditionalFormat::customNumFormat()
	Returns the custom number format string */
EXCEL_METHOD(ConditionalFormat, customNumFormat)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	const char *result = xlConditionalFormatCustomNumFormat(condformat);
	if (result) {
		RETURN_STRING(result);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setCustomNumFormat(string format)
	Sets the custom number format string */
EXCEL_METHOD(ConditionalFormat, setCustomNumFormat)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_string *format;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &format) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetCustomNumFormat(condformat, ZSTR_VAL(format));
}
/* }}} */

/* ----------------------------------------------------------------
   Border: setBorder / setBorderColor (all sides at once)
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormat::setBorder(int style)
	Sets border style for all sides */
EXCEL_METHOD(ConditionalFormat, setBorder)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorder(condformat, (int)style);
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderColor(int color)
	Sets border color for all sides */
EXCEL_METHOD(ConditionalFormat, setBorderColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderColor(condformat, (int)color);
}
/* }}} */

/* ----------------------------------------------------------------
   Border sides: left, right, top, bottom (style + color)
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelConditionalFormat::borderLeft()
	Returns the left border style */
EXCEL_METHOD(ConditionalFormat, borderLeft)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderLeft(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderLeft(int style)
	Sets the left border style */
EXCEL_METHOD(ConditionalFormat, setBorderLeft)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderLeft(condformat, (int)style);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderRight()
	Returns the right border style */
EXCEL_METHOD(ConditionalFormat, borderRight)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderRight(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderRight(int style)
	Sets the right border style */
EXCEL_METHOD(ConditionalFormat, setBorderRight)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderRight(condformat, (int)style);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderTop()
	Returns the top border style */
EXCEL_METHOD(ConditionalFormat, borderTop)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderTop(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderTop(int style)
	Sets the top border style */
EXCEL_METHOD(ConditionalFormat, setBorderTop)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderTop(condformat, (int)style);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderBottom()
	Returns the bottom border style */
EXCEL_METHOD(ConditionalFormat, borderBottom)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderBottom(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderBottom(int style)
	Sets the bottom border style */
EXCEL_METHOD(ConditionalFormat, setBorderBottom)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long style;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &style) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderBottom(condformat, (int)style);
}
/* }}} */

/* ----------------------------------------------------------------
   Border side colors
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelConditionalFormat::borderLeftColor()
	Returns the left border color */
EXCEL_METHOD(ConditionalFormat, borderLeftColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderLeftColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderLeftColor(int color)
	Sets the left border color */
EXCEL_METHOD(ConditionalFormat, setBorderLeftColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderLeftColor(condformat, (int)color);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderRightColor()
	Returns the right border color */
EXCEL_METHOD(ConditionalFormat, borderRightColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderRightColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderRightColor(int color)
	Sets the right border color */
EXCEL_METHOD(ConditionalFormat, setBorderRightColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderRightColor(condformat, (int)color);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderTopColor()
	Returns the top border color */
EXCEL_METHOD(ConditionalFormat, borderTopColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderTopColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderTopColor(int color)
	Sets the top border color */
EXCEL_METHOD(ConditionalFormat, setBorderTopColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderTopColor(condformat, (int)color);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::borderBottomColor()
	Returns the bottom border color */
EXCEL_METHOD(ConditionalFormat, borderBottomColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatBorderBottomColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setBorderBottomColor(int color)
	Sets the bottom border color */
EXCEL_METHOD(ConditionalFormat, setBorderBottomColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetBorderBottomColor(condformat, (int)color);
}
/* }}} */

/* ----------------------------------------------------------------
   Fill pattern + foreground/background colors
   ---------------------------------------------------------------- */

/* {{{ proto int ExcelConditionalFormat::fillPattern()
	Returns the fill pattern */
EXCEL_METHOD(ConditionalFormat, fillPattern)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatFillPattern(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setFillPattern(int pattern)
	Sets the fill pattern */
EXCEL_METHOD(ConditionalFormat, setFillPattern)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long pattern;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &pattern) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetFillPattern(condformat, (int)pattern);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::patternForegroundColor()
	Returns the pattern foreground color */
EXCEL_METHOD(ConditionalFormat, patternForegroundColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatPatternForegroundColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setPatternForegroundColor(int color)
	Sets the pattern foreground color */
EXCEL_METHOD(ConditionalFormat, setPatternForegroundColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetPatternForegroundColor(condformat, (int)color);
}
/* }}} */

/* {{{ proto int ExcelConditionalFormat::patternBackgroundColor()
	Returns the pattern background color */
EXCEL_METHOD(ConditionalFormat, patternBackgroundColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	RETURN_LONG(xlConditionalFormatPatternBackgroundColor(condformat));
}
/* }}} */

/* {{{ proto void ExcelConditionalFormat::setPatternBackgroundColor(int color)
	Sets the pattern background color */
EXCEL_METHOD(ConditionalFormat, setPatternBackgroundColor)
{
	ConditionalFormatHandle condformat;
	zval *object = getThis();
	zend_long color;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &color) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMAT_FROM_OBJECT(condformat, object);

	xlConditionalFormatSetPatternBackgroundColor(condformat, (int)color);
}
/* }}} */

/* ----------------------------------------------------------------
   ConditionalFormat arginfo
   ---------------------------------------------------------------- */

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormat___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormat_void, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormat_setInt, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormat_setString, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

/* ----------------------------------------------------------------
   ConditionalFormat method entry table
   ---------------------------------------------------------------- */

static zend_function_entry excel_funcs_condformat[] = {
	EXCEL_ME(ConditionalFormat, __construct, arginfo_ConditionalFormat___construct, ZEND_ACC_PUBLIC|ZEND_ACC_FINAL)
	/* Font */
	EXCEL_ME(ConditionalFormat, font, arginfo_ConditionalFormat_void, 0)
	/* Num format */
	EXCEL_ME(ConditionalFormat, numFormat, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setNumFormat, arginfo_ConditionalFormat_setInt, 0)
	/* Custom num format */
	EXCEL_ME(ConditionalFormat, customNumFormat, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setCustomNumFormat, arginfo_ConditionalFormat_setString, 0)
	/* Border all sides */
	EXCEL_ME(ConditionalFormat, setBorder, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, setBorderColor, arginfo_ConditionalFormat_setInt, 0)
	/* Border left */
	EXCEL_ME(ConditionalFormat, borderLeft, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderLeft, arginfo_ConditionalFormat_setInt, 0)
	/* Border right */
	EXCEL_ME(ConditionalFormat, borderRight, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderRight, arginfo_ConditionalFormat_setInt, 0)
	/* Border top */
	EXCEL_ME(ConditionalFormat, borderTop, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderTop, arginfo_ConditionalFormat_setInt, 0)
	/* Border bottom */
	EXCEL_ME(ConditionalFormat, borderBottom, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderBottom, arginfo_ConditionalFormat_setInt, 0)
	/* Border colors */
	EXCEL_ME(ConditionalFormat, borderLeftColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderLeftColor, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, borderRightColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderRightColor, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, borderTopColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderTopColor, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, borderBottomColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setBorderBottomColor, arginfo_ConditionalFormat_setInt, 0)
	/* Fill */
	EXCEL_ME(ConditionalFormat, fillPattern, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setFillPattern, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, patternForegroundColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setPatternForegroundColor, arginfo_ConditionalFormat_setInt, 0)
	EXCEL_ME(ConditionalFormat, patternBackgroundColor, arginfo_ConditionalFormat_void, 0)
	EXCEL_ME(ConditionalFormat, setPatternBackgroundColor, arginfo_ConditionalFormat_setInt, 0)
	PHP_FE_END
};

/* ================================================================
   ExcelConditionalFormatting
   ================================================================ */

zend_class_entry *excel_ce_condformatting;
zend_object_handlers excel_object_handlers_condformatting;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_condformatting_object_free_storage(zend_object *object)
{
	zend_object_std_dtor(object);
}

static zend_object *excel_object_new_condformatting_ex(zend_class_entry *class_type, excel_condformatting_object **ptr)
{
	excel_condformatting_object *intern;

	intern = zend_object_alloc(sizeof(excel_condformatting_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_condformatting;

	return &intern->std;
}

zend_object *excel_object_new_condformatting(zend_class_entry *class_type)
{
	return excel_object_new_condformatting_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelConditionalFormatting::__construct()
   ---------------------------------------------------------------- */

EXCEL_METHOD(ConditionalFormatting, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelConditionalFormatting cannot be instantiated directly, use ExcelSheet::addConditionalFormatting()", 0);
	RETURN_THROWS();
}

/* ----------------------------------------------------------------
   addRange
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addRange(int rowFirst, int rowLast, int colFirst, int colLast)
	Adds a cell range for conditional formatting */
EXCEL_METHOD(ConditionalFormatting, addRange)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long rowFirst, rowLast, colFirst, colLast;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "llll", &rowFirst, &rowLast, &colFirst, &colLast) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	xlConditionalFormattingAddRange(condformatting, (int)rowFirst, (int)rowLast, (int)colFirst, (int)colLast);
}
/* }}} */

/* ----------------------------------------------------------------
   addRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addRule(int type, ExcelConditionalFormat cFormat, string value [, bool stopIfTrue])
	Adds a conditional formatting rule */
EXCEL_METHOD(ConditionalFormatting, addRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long type;
	zval *zcformat;
	zend_string *value;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lOS|b", &type, &zcformat, excel_ce_condformat, &value, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddRule(condformatting, (int)type, cfo->condformat, ZSTR_VAL(value), (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   addTopRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addTopRule(ExcelConditionalFormat cFormat, int value [, bool bottom [, bool percent [, bool stopIfTrue]]])
	Adds a top/bottom rule */
EXCEL_METHOD(ConditionalFormatting, addTopRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zval *zcformat;
	zend_long value;
	zend_bool bottom = 0, percent = 0, stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "Ol|bbb", &zcformat, excel_ce_condformat, &value, &bottom, &percent, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddTopRule(condformatting, cfo->condformat, (int)value, (int)bottom, (int)percent, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   addOpNumRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addOpNumRule(int op, ExcelConditionalFormat cFormat, float value1, float value2 [, bool stopIfTrue])
	Adds a numeric operator rule */
EXCEL_METHOD(ConditionalFormatting, addOpNumRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long op;
	zval *zcformat;
	double value1, value2;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lOdd|b", &op, &zcformat, excel_ce_condformat, &value1, &value2, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddOpNumRule(condformatting, (int)op, cfo->condformat, value1, value2, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   addOpStrRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addOpStrRule(int op, ExcelConditionalFormat cFormat, string value1, string value2 [, bool stopIfTrue])
	Adds a string operator rule */
EXCEL_METHOD(ConditionalFormatting, addOpStrRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long op;
	zval *zcformat;
	zend_string *value1, *value2;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lOSS|b", &op, &zcformat, excel_ce_condformat, &value1, &value2, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddOpStrRule(condformatting, (int)op, cfo->condformat, ZSTR_VAL(value1), ZSTR_VAL(value2), (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   addAboveAverageRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addAboveAverageRule(ExcelConditionalFormat cFormat [, bool aboveAverage [, bool equalAverage [, int stdDev [, bool stopIfTrue]]]])
	Adds an above/below average rule */
EXCEL_METHOD(ConditionalFormatting, addAboveAverageRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zval *zcformat;
	zend_bool aboveAverage = 1, equalAverage = 0, stopIfTrue = 0;
	zend_long stdDev = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "O|bblb", &zcformat, excel_ce_condformat, &aboveAverage, &equalAverage, &stdDev, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddAboveAverageRule(condformatting, cfo->condformat, (int)aboveAverage, (int)equalAverage, (int)stdDev, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   addTimePeriodRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::addTimePeriodRule(ExcelConditionalFormat cFormat, int timePeriod [, bool stopIfTrue])
	Adds a time period rule */
EXCEL_METHOD(ConditionalFormatting, addTimePeriodRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zval *zcformat;
	zend_long timePeriod;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "Ol|b", &zcformat, excel_ce_condformat, &timePeriod, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	excel_condformat_object *cfo = Z_EXCEL_CONDFORMAT_OBJ_P(zcformat);

	xlConditionalFormattingAddTimePeriodRule(condformatting, cfo->condformat, (int)timePeriod, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   add2ColorScaleRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::add2ColorScaleRule(int minColor, int maxColor, int minType, float minValue, int maxType, float maxValue [, bool stopIfTrue])
	Adds a 2-color scale rule with numeric values */
EXCEL_METHOD(ConditionalFormatting, add2ColorScaleRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long minColor, maxColor, minType, maxType;
	double minValue, maxValue;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "llldld|b", &minColor, &maxColor, &minType, &minValue, &maxType, &maxValue, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	xlConditionalFormattingAdd2ColorScaleRule(condformatting, (int)minColor, (int)maxColor, (int)minType, minValue, (int)maxType, maxValue, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   add2ColorScaleFormulaRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::add2ColorScaleFormulaRule(int minColor, int maxColor, int minType, string minValue, int maxType, string maxValue [, bool stopIfTrue])
	Adds a 2-color scale rule with formula values */
EXCEL_METHOD(ConditionalFormatting, add2ColorScaleFormulaRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long minColor, maxColor, minType, maxType;
	zend_string *minValue, *maxValue;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "llSlS|b", &minColor, &maxColor, &minType, &minValue, &maxType, &maxValue, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	xlConditionalFormattingAdd2ColorScaleFormulaRule(condformatting, (int)minColor, (int)maxColor, (int)minType, ZSTR_VAL(minValue), (int)maxType, ZSTR_VAL(maxValue), (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   add3ColorScaleRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::add3ColorScaleRule(int minColor, int midColor, int maxColor, int minType, float minValue, int midType, float midValue, int maxType, float maxValue [, bool stopIfTrue])
	Adds a 3-color scale rule with numeric values */
EXCEL_METHOD(ConditionalFormatting, add3ColorScaleRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long minColor, midColor, maxColor, minType, midType, maxType;
	double minValue, midValue, maxValue;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lllldldld|b", &minColor, &midColor, &maxColor, &minType, &minValue, &midType, &midValue, &maxType, &maxValue, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	xlConditionalFormattingAdd3ColorScaleRule(condformatting, (int)minColor, (int)midColor, (int)maxColor, (int)minType, minValue, (int)midType, midValue, (int)maxType, maxValue, (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   add3ColorScaleFormulaRule
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelConditionalFormatting::add3ColorScaleFormulaRule(int minColor, int midColor, int maxColor, int minType, string minValue, int midType, string midValue, int maxType, string maxValue [, bool stopIfTrue])
	Adds a 3-color scale rule with formula values */
EXCEL_METHOD(ConditionalFormatting, add3ColorScaleFormulaRule)
{
	ConditionalFormattingHandle condformatting;
	zval *object = getThis();
	zend_long minColor, midColor, maxColor, minType, midType, maxType;
	zend_string *minValue, *midValue, *maxValue;
	zend_bool stopIfTrue = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "lllSlSlS|b", &minColor, &midColor, &maxColor, &minType, &minValue, &midType, &midValue, &maxType, &maxValue, &stopIfTrue) == FAILURE) {
		RETURN_THROWS();
	}

	CONDFORMATTING_FROM_OBJECT(condformatting, object);

	xlConditionalFormattingAdd3ColorScaleFormulaRule(condformatting, (int)minColor, (int)midColor, (int)maxColor, (int)minType, ZSTR_VAL(minValue), (int)midType, ZSTR_VAL(midValue), (int)maxType, ZSTR_VAL(maxValue), (int)stopIfTrue);
}
/* }}} */

/* ----------------------------------------------------------------
   ConditionalFormatting arginfo
   ---------------------------------------------------------------- */

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addRange, 0, 0, 4)
	ZEND_ARG_INFO(0, rowFirst)
	ZEND_ARG_INFO(0, rowLast)
	ZEND_ARG_INFO(0, colFirst)
	ZEND_ARG_INFO(0, colLast)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addRule, 0, 0, 3)
	ZEND_ARG_INFO(0, type)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, value)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addTopRule, 0, 0, 2)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, value)
	ZEND_ARG_INFO(0, bottom)
	ZEND_ARG_INFO(0, percent)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addOpNumRule, 0, 0, 4)
	ZEND_ARG_INFO(0, op)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, value1)
	ZEND_ARG_INFO(0, value2)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addOpStrRule, 0, 0, 4)
	ZEND_ARG_INFO(0, op)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, value1)
	ZEND_ARG_INFO(0, value2)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addAboveAverageRule, 0, 0, 1)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, aboveAverage)
	ZEND_ARG_INFO(0, equalAverage)
	ZEND_ARG_INFO(0, stdDev)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_addTimePeriodRule, 0, 0, 2)
	ZEND_ARG_OBJ_INFO(0, cFormat, ExcelConditionalFormat, 0)
	ZEND_ARG_INFO(0, timePeriod)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_add2ColorScaleRule, 0, 0, 6)
	ZEND_ARG_INFO(0, minColor)
	ZEND_ARG_INFO(0, maxColor)
	ZEND_ARG_INFO(0, minType)
	ZEND_ARG_INFO(0, minValue)
	ZEND_ARG_INFO(0, maxType)
	ZEND_ARG_INFO(0, maxValue)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_add2ColorScaleFormulaRule, 0, 0, 6)
	ZEND_ARG_INFO(0, minColor)
	ZEND_ARG_INFO(0, maxColor)
	ZEND_ARG_INFO(0, minType)
	ZEND_ARG_INFO(0, minValue)
	ZEND_ARG_INFO(0, maxType)
	ZEND_ARG_INFO(0, maxValue)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_add3ColorScaleRule, 0, 0, 9)
	ZEND_ARG_INFO(0, minColor)
	ZEND_ARG_INFO(0, midColor)
	ZEND_ARG_INFO(0, maxColor)
	ZEND_ARG_INFO(0, minType)
	ZEND_ARG_INFO(0, minValue)
	ZEND_ARG_INFO(0, midType)
	ZEND_ARG_INFO(0, midValue)
	ZEND_ARG_INFO(0, maxType)
	ZEND_ARG_INFO(0, maxValue)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_ConditionalFormatting_add3ColorScaleFormulaRule, 0, 0, 9)
	ZEND_ARG_INFO(0, minColor)
	ZEND_ARG_INFO(0, midColor)
	ZEND_ARG_INFO(0, maxColor)
	ZEND_ARG_INFO(0, minType)
	ZEND_ARG_INFO(0, minValue)
	ZEND_ARG_INFO(0, midType)
	ZEND_ARG_INFO(0, midValue)
	ZEND_ARG_INFO(0, maxType)
	ZEND_ARG_INFO(0, maxValue)
	ZEND_ARG_INFO(0, stopIfTrue)
ZEND_END_ARG_INFO()

/* ----------------------------------------------------------------
   ConditionalFormatting method entry table
   ---------------------------------------------------------------- */

static zend_function_entry excel_funcs_condformatting[] = {
	EXCEL_ME(ConditionalFormatting, __construct, arginfo_ConditionalFormatting___construct, ZEND_ACC_PUBLIC|ZEND_ACC_FINAL)
	EXCEL_ME(ConditionalFormatting, addRange, arginfo_ConditionalFormatting_addRange, 0)
	EXCEL_ME(ConditionalFormatting, addRule, arginfo_ConditionalFormatting_addRule, 0)
	EXCEL_ME(ConditionalFormatting, addTopRule, arginfo_ConditionalFormatting_addTopRule, 0)
	EXCEL_ME(ConditionalFormatting, addOpNumRule, arginfo_ConditionalFormatting_addOpNumRule, 0)
	EXCEL_ME(ConditionalFormatting, addOpStrRule, arginfo_ConditionalFormatting_addOpStrRule, 0)
	EXCEL_ME(ConditionalFormatting, addAboveAverageRule, arginfo_ConditionalFormatting_addAboveAverageRule, 0)
	EXCEL_ME(ConditionalFormatting, addTimePeriodRule, arginfo_ConditionalFormatting_addTimePeriodRule, 0)
	EXCEL_ME(ConditionalFormatting, add2ColorScaleRule, arginfo_ConditionalFormatting_add2ColorScaleRule, 0)
	EXCEL_ME(ConditionalFormatting, add2ColorScaleFormulaRule, arginfo_ConditionalFormatting_add2ColorScaleFormulaRule, 0)
	EXCEL_ME(ConditionalFormatting, add3ColorScaleRule, arginfo_ConditionalFormatting_add3ColorScaleRule, 0)
	EXCEL_ME(ConditionalFormatting, add3ColorScaleFormulaRule, arginfo_ConditionalFormatting_add3ColorScaleFormulaRule, 0)
	PHP_FE_END
};

/* ================================================================
   Class registration
   ================================================================ */

void excel_condformat_register(void)
{
	zend_class_entry ce;

	/* ExcelConditionalFormat */
	INIT_CLASS_ENTRY(ce, "ExcelConditionalFormat", excel_funcs_condformat);
	ce.create_object = excel_object_new_condformat;
	excel_ce_condformat = zend_register_internal_class_ex(&ce, NULL);
	memcpy(&excel_object_handlers_condformat, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_condformat.offset = XtOffsetOf(excel_condformat_object, std);
	excel_object_handlers_condformat.free_obj = excel_condformat_object_free_storage;
	excel_object_handlers_condformat.clone_obj = NULL;

	/* ExcelConditionalFormatting */
	INIT_CLASS_ENTRY(ce, "ExcelConditionalFormatting", excel_funcs_condformatting);
	ce.create_object = excel_object_new_condformatting;
	excel_ce_condformatting = zend_register_internal_class_ex(&ce, NULL);
	memcpy(&excel_object_handlers_condformatting, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_condformatting.offset = XtOffsetOf(excel_condformatting_object, std);
	excel_object_handlers_condformatting.free_obj = excel_condformatting_object_free_storage;
	excel_object_handlers_condformatting.clone_obj = NULL;

	/* CFormatType constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_BEGINWITH", CFORMAT_BEGINWITH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_CONTAINSBLANKS", CFORMAT_CONTAINSBLANKS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_CONTAINSERRORS", CFORMAT_CONTAINSERRORS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_CONTAINSTEXT", CFORMAT_CONTAINSTEXT);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_DUPLICATEVALUES", CFORMAT_DUPLICATEVALUES);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_ENDSWITH", CFORMAT_ENDSWITH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_EXPRESSION", CFORMAT_EXPRESSION);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_NOTCONTAINSBLANKS", CFORMAT_NOTCONTAINSBLANKS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_NOTCONTAINSERRORS", CFORMAT_NOTCONTAINSERRORS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_NOTCONTAINSTEXT", CFORMAT_NOTCONTAINSTEXT);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFORMAT_UNIQUEVALUES", CFORMAT_UNIQUEVALUES);

	/* CFormatOperator constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_LESSTHAN", CFOPERATOR_LESSTHAN);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_LESSTHANOREQUAL", CFOPERATOR_LESSTHANOREQUAL);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_EQUAL", CFOPERATOR_EQUAL);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_NOTEQUAL", CFOPERATOR_NOTEQUAL);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_GREATERTHANOREQUAL", CFOPERATOR_GREATERTHANOREQUAL);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_GREATERTHAN", CFOPERATOR_GREATERTHAN);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_BETWEEN", CFOPERATOR_BETWEEN);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_NOTBETWEEN", CFOPERATOR_NOTBETWEEN);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_CONTAINSTEXT", CFOPERATOR_CONTAINSTEXT);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_NOTCONTAINS", CFOPERATOR_NOTCONTAINS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_BEGINSWITH", CFOPERATOR_BEGINSWITH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFOPERATOR_ENDSWITH", CFOPERATOR_ENDSWITH);

	/* CFormatTimePeriod constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_LAST7DAYS", CFTP_LAST7DAYS);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_LASTMONTH", CFTP_LASTMONTH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_LASTWEEK", CFTP_LASTWEEK);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_NEXTMONTH", CFTP_NEXTMONTH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_NEXTWEEK", CFTP_NEXTWEEK);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_THISMONTH", CFTP_THISMONTH);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_THISWEEK", CFTP_THISWEEK);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_TODAY", CFTP_TODAY);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_TOMORROW", CFTP_TOMORROW);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFTP_YESTERDAY", CFTP_YESTERDAY);

	/* CFVOType constants */
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_MIN", CFVO_MIN);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_MAX", CFVO_MAX);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_FORMULA", CFVO_FORMULA);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_NUMBER", CFVO_NUMBER);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_PERCENT", CFVO_PERCENT);
	REGISTER_EXCEL_CLASS_CONST_LONG(condformatting, "CFVO_PERCENTILE", CFVO_PERCENTILE);
}

#else

void excel_condformat_register(void)
{
	/* noop: LibXL < 4.1.0 */
}

#endif
