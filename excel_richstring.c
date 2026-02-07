#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x03090000

zend_class_entry *excel_ce_richstring;
zend_object_handlers excel_object_handlers_richstring;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_richstring_object_free_storage(zend_object *object)
{
	excel_richstring_object *intern = php_excel_richstring_object_fetch_object(object);
	zend_object_std_dtor(&intern->std);
}

static zend_object *excel_object_new_richstring_ex(zend_class_entry *class_type, excel_richstring_object **ptr)
{
	excel_richstring_object *intern;

	intern = zend_object_alloc(sizeof(excel_richstring_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_richstring;

	return &intern->std;
}

zend_object *excel_object_new_richstring(zend_class_entry *class_type)
{
	return excel_object_new_richstring_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelRichString methods
   ---------------------------------------------------------------- */

/* {{{ proto ExcelFont ExcelRichString::addFont([ExcelFont initFont])
   Add a font to the rich string, optionally based on an existing font */
EXCEL_METHOD(RichString, addFont)
{
	RichStringHandle richstring;
	BookHandle book;
	zval *object = getThis();
	zval *fob = NULL;
	FontHandle font = NULL;
	FontHandle new_font;
	excel_font_object *fo;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "|O!", &fob, excel_ce_font) == FAILURE) {
		RETURN_THROWS();
	}

	RICHSTRING_AND_BOOK_FROM_OBJECT(richstring, book, object);

	if (fob) {
		FONT_FROM_OBJECT(font, fob);
	}

	new_font = xlRichStringAddFont(richstring, font);
	if (!new_font) {
		RETURN_FALSE;
	}

	ZVAL_OBJ(return_value, excel_object_new_font(excel_ce_font));
	fo = Z_EXCEL_FONT_OBJ_P(return_value);
	fo->font = new_font;
	fo->book = book;
}
/* }}} */

/* {{{ proto bool ExcelRichString::addText(string text[, ExcelFont font])
   Add text to the rich string with an optional font */
EXCEL_METHOD(RichString, addText)
{
	RichStringHandle richstring;
	zval *object = getThis();
	char *text;
	size_t text_len;
	zval *fob = NULL;
	FontHandle font = NULL;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "s|O!", &text, &text_len, &fob, excel_ce_font) == FAILURE) {
		RETURN_THROWS();
	}

	RICHSTRING_FROM_OBJECT(richstring, object);

	if (fob) {
		FONT_FROM_OBJECT(font, fob);
	}

	xlRichStringAddText(richstring, text, font);

	RETURN_TRUE;
}
/* }}} */

/* {{{ proto array ExcelRichString::getText(int index)
   Get text and font at the given index. Returns array{text: string, font: ExcelFont} */
EXCEL_METHOD(RichString, getText)
{
	RichStringHandle richstring;
	BookHandle book;
	zval *object = getThis();
	zend_long index;
	FontHandle font = NULL;
	const char *text;
	excel_font_object *fo;
	zval zv_font;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "l", &index) == FAILURE) {
		RETURN_THROWS();
	}

	RICHSTRING_AND_BOOK_FROM_OBJECT(richstring, book, object);

	text = xlRichStringGetText(richstring, (int)index, &font);
	if (!text) {
		RETURN_FALSE;
	}

	array_init(return_value);
	add_assoc_string(return_value, "text", (char *)text);

	if (font) {
		ZVAL_OBJ(&zv_font, excel_object_new_font(excel_ce_font));
		fo = Z_EXCEL_FONT_OBJ_P(&zv_font);
		fo->font = font;
		fo->book = book;
		add_assoc_zval(return_value, "font", &zv_font);
	} else {
		add_assoc_null(return_value, "font");
	}
}
/* }}} */

/* {{{ proto int ExcelRichString::textSize()
   Get the number of text segments in the rich string */
EXCEL_METHOD(RichString, textSize)
{
	RichStringHandle richstring;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	RICHSTRING_FROM_OBJECT(richstring, object);

	RETURN_LONG(xlRichStringTextSize(richstring));
}
/* }}} */

/* {{{ proto void ExcelRichString::__construct() */
EXCEL_METHOD(RichString, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelRichString cannot be instantiated directly, use ExcelBook::addRichString()", 0);
}
/* }}} */

/* ----------------------------------------------------------------
   arginfo
   ---------------------------------------------------------------- */

ZEND_BEGIN_ARG_INFO_EX(arginfo_RichString___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_RichString_addFont, 0, 0, 0)
	ZEND_ARG_OBJ_INFO(0, initFont, ExcelFont, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_RichString_addText, 0, 0, 1)
	ZEND_ARG_INFO(0, text)
	ZEND_ARG_OBJ_INFO(0, font, ExcelFont, 1)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_RichString_getText, 0, 0, 1)
	ZEND_ARG_INFO(0, index)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_RichString_textSize, 0, 0, 0)
ZEND_END_ARG_INFO()

/* ----------------------------------------------------------------
   Method table
   ---------------------------------------------------------------- */

static zend_function_entry excel_funcs_richstring[] = {
	EXCEL_ME(RichString, __construct, arginfo_RichString___construct, ZEND_ACC_PUBLIC|ZEND_ACC_FINAL)
	EXCEL_ME(RichString, addFont, arginfo_RichString_addFont, 0)
	EXCEL_ME(RichString, addText, arginfo_RichString_addText, 0)
	EXCEL_ME(RichString, getText, arginfo_RichString_getText, 0)
	EXCEL_ME(RichString, textSize, arginfo_RichString_textSize, 0)
	PHP_FE_END
};

/* ----------------------------------------------------------------
   Class registration
   ---------------------------------------------------------------- */

void excel_richstring_register(void)
{
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "ExcelRichString", excel_funcs_richstring);
	ce.create_object = excel_object_new_richstring;
	excel_ce_richstring = zend_register_internal_class_ex(&ce, NULL);
	memcpy(&excel_object_handlers_richstring, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_richstring.offset = XtOffsetOf(excel_richstring_object, std);
	excel_object_handlers_richstring.free_obj = excel_richstring_object_free_storage;
	excel_object_handlers_richstring.clone_obj = NULL;
}

#else

void excel_richstring_register(void)
{
	/* noop: LibXL < 3.9.0 */
}

#endif
