/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2014 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author: Ilia Alshanetsky <ilia@ilia.ws>                              |
  +----------------------------------------------------------------------+
*/

#ifndef PHP_EXCEL_H
#define PHP_EXCEL_H 1

extern zend_module_entry excel_module_entry;
#define phpext_excel_ptr &excel_module_entry

ZEND_BEGIN_MODULE_GLOBALS(excel)
	char *ini_license_name;
	char *ini_license_key;
	int ini_skip_empty;
ZEND_END_MODULE_GLOBALS(excel)


#ifdef PHP_WIN32
#define PHP_EXCEL_API __declspec(dllexport)
#else
#define PHP_EXCEL_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

# define PHP_EXCEL_ERROR_HANDLING() \
	zend_error_handling error_handling; \
	zend_replace_error_handling(EH_THROW, NULL, &error_handling);
# define PHP_EXCEL_RESTORE_ERRORS() zend_restore_error_handling(&error_handling);

#ifndef Z_SET_ISREF_P
# define Z_SET_ISREF_P(pz)				(pz)->is_ref = 1
# define Z_SET_ISREF_PP(ppz)			Z_SET_ISREF_P(*(ppz))
# define Z_SET_ISREF(z)				Z_SET_ISREF_P(&(z))
#endif

#ifndef Z_SET_REFCOUNT_P
# define Z_SET_REFCOUNT_P(pz, rc)      (pz)->refcount = rc
# define Z_SET_REFCOUNT_PP(ppz, rc)    Z_SET_REFCOUNT_P(*(ppz), rc)
#endif

/* PHP 8 compatibility */
#if PHP_MAJOR_VERSION >= 8
# ifndef ZEND_BOOL_T
#  define ZEND_BOOL_T
typedef bool zend_bool;
# endif
#endif

#ifndef PHP_FE_END
# define PHP_FE_END {NULL, NULL, NULL}
#endif

/* ----------------------------------------------------------------
   Object structures
   ---------------------------------------------------------------- */

typedef struct _excel_book_object {
	BookHandle book;
	zend_object std;
} excel_book_object;

typedef struct _excel_sheet_object {
	SheetHandle	sheet;
	BookHandle book;
	zend_object std;
} excel_sheet_object;

typedef struct _excel_font_object {
	FontHandle font;
	BookHandle book;
	zend_object std;
} excel_font_object;

typedef struct _excel_format_object {
	FormatHandle format;
	BookHandle book;
	zend_object std;
} excel_format_object;

#if LIBXL_VERSION >= 0x03070000
typedef struct _excel_autofilter_object {
	AutoFilterHandle autofilter;
	SheetHandle sheet;
	zend_object std;
} excel_autofilter_object;

typedef struct _excel_filtercolumn_object {
	FilterColumnHandle filtercolumn;
	AutoFilterHandle autofilter;
	zend_object std;
} excel_filtercolumn_object;
#endif

#if LIBXL_VERSION >= 0x03090000
typedef struct _excel_richstring_object {
	RichStringHandle richstring;
	BookHandle book;
	zend_object std;
} excel_richstring_object;
#endif

#if LIBXL_VERSION >= 0x04000000
typedef struct _excel_formcontrol_object {
	FormControlHandle formcontrol;
	SheetHandle sheet;
	BookHandle book;
	zend_object std;
} excel_formcontrol_object;
#endif

#if LIBXL_VERSION >= 0x04010000
typedef struct _excel_condformat_object {
	ConditionalFormatHandle condformat;
	BookHandle book;
	zend_object std;
} excel_condformat_object;

typedef struct _excel_condformatting_object {
	ConditionalFormattingHandle condformatting;
	SheetHandle sheet;
	BookHandle book;
	zend_object std;
} excel_condformatting_object;
#endif

#if LIBXL_VERSION >= 0x04050000
typedef struct _excel_coreproperties_object {
	CorePropertiesHandle coreproperties;
	BookHandle book;
	zend_object std;
} excel_coreproperties_object;
#endif

/* ----------------------------------------------------------------
   Inline fetch functions
   ---------------------------------------------------------------- */

static inline excel_book_object *php_excel_book_object_fetch_object(zend_object *obj) {
	return (excel_book_object *)((char *)(obj) - XtOffsetOf(excel_book_object, std));
}

static inline excel_sheet_object *php_excel_sheet_object_fetch_object(zend_object *obj) {
	return (excel_sheet_object *)((char *)(obj) - XtOffsetOf(excel_sheet_object, std));
}

static inline excel_font_object *php_excel_font_object_fetch_object(zend_object *obj) {
	return (excel_font_object *)((char *)(obj) - XtOffsetOf(excel_font_object, std));
}

static inline excel_format_object *php_excel_format_object_fetch_object(zend_object *obj) {
	return (excel_format_object *)((char *)(obj) - XtOffsetOf(excel_format_object, std));
}

#if LIBXL_VERSION >= 0x03070000
static inline excel_autofilter_object *php_excel_autofilter_object_fetch_object(zend_object *obj) {
	return (excel_autofilter_object *)((char *)(obj) - XtOffsetOf(excel_autofilter_object, std));
}

static inline excel_filtercolumn_object *php_excel_filtercolumn_object_fetch_object(zend_object *obj) {
	return (excel_filtercolumn_object *)((char *)(obj) - XtOffsetOf(excel_filtercolumn_object, std));
}
#endif

#if LIBXL_VERSION >= 0x03090000
static inline excel_richstring_object *php_excel_richstring_object_fetch_object(zend_object *obj) {
	return (excel_richstring_object *)((char *)(obj) - XtOffsetOf(excel_richstring_object, std));
}
#endif

#if LIBXL_VERSION >= 0x04000000
static inline excel_formcontrol_object *php_excel_formcontrol_object_fetch_object(zend_object *obj) {
	return (excel_formcontrol_object *)((char *)(obj) - XtOffsetOf(excel_formcontrol_object, std));
}
#endif

#if LIBXL_VERSION >= 0x04010000
static inline excel_condformat_object *php_excel_condformat_object_fetch_object(zend_object *obj) {
	return (excel_condformat_object *)((char *)(obj) - XtOffsetOf(excel_condformat_object, std));
}

static inline excel_condformatting_object *php_excel_condformatting_object_fetch_object(zend_object *obj) {
	return (excel_condformatting_object *)((char *)(obj) - XtOffsetOf(excel_condformatting_object, std));
}
#endif

#if LIBXL_VERSION >= 0x04050000
static inline excel_coreproperties_object *php_excel_coreproperties_object_fetch_object(zend_object *obj) {
	return (excel_coreproperties_object *)((char *)(obj) - XtOffsetOf(excel_coreproperties_object, std));
}
#endif

/* ----------------------------------------------------------------
   Z_EXCEL_*_OBJ_P macros
   ---------------------------------------------------------------- */

#define Z_EXCEL_BOOK_OBJ_P(zv) php_excel_book_object_fetch_object(Z_OBJ_P(zv));
#define Z_EXCEL_SHEET_OBJ_P(zv) php_excel_sheet_object_fetch_object(Z_OBJ_P(zv));
#define Z_EXCEL_FONT_OBJ_P(zv) php_excel_font_object_fetch_object(Z_OBJ_P(zv));
#define Z_EXCEL_FORMAT_OBJ_P(zv) php_excel_format_object_fetch_object(Z_OBJ_P(zv));

#if LIBXL_VERSION >= 0x03070000
#define Z_EXCEL_AUTOFILTER_OBJ_P(zv) php_excel_autofilter_object_fetch_object(Z_OBJ_P(zv));
#define Z_EXCEL_FILTERCOLUMN_OBJ_P(zv) php_excel_filtercolumn_object_fetch_object(Z_OBJ_P(zv));
#endif

#if LIBXL_VERSION >= 0x03090000
#define Z_EXCEL_RICHSTRING_OBJ_P(zv) php_excel_richstring_object_fetch_object(Z_OBJ_P(zv));
#endif

#if LIBXL_VERSION >= 0x04000000
#define Z_EXCEL_FORMCONTROL_OBJ_P(zv) php_excel_formcontrol_object_fetch_object(Z_OBJ_P(zv));
#endif

#if LIBXL_VERSION >= 0x04010000
#define Z_EXCEL_CONDFORMAT_OBJ_P(zv) php_excel_condformat_object_fetch_object(Z_OBJ_P(zv));
#define Z_EXCEL_CONDFORMATTING_OBJ_P(zv) php_excel_condformatting_object_fetch_object(Z_OBJ_P(zv));
#endif

#if LIBXL_VERSION >= 0x04050000
#define Z_EXCEL_COREPROPERTIES_OBJ_P(zv) php_excel_coreproperties_object_fetch_object(Z_OBJ_P(zv));
#endif

/* ----------------------------------------------------------------
   *_FROM_OBJECT macros (require zend_exceptions.h)
   ---------------------------------------------------------------- */

extern zend_class_entry *excel_ce_exception;

#define BOOK_FROM_OBJECT(book, object) \
	{ \
		excel_book_object *obj = Z_EXCEL_BOOK_OBJ_P(object); \
		book = obj->book; \
		if (!book) { \
			zend_throw_exception(excel_ce_exception, "The book wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define SHEET_FROM_OBJECT(sheet, object) \
	{ \
		excel_sheet_object *obj = Z_EXCEL_SHEET_OBJ_P(object); \
		sheet = obj->sheet; \
		if (!sheet) { \
			zend_throw_exception(excel_ce_exception, "The sheet wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define SHEET_AND_BOOK_FROM_OBJECT(sheet, book, object) \
	{ \
		excel_sheet_object *obj = Z_EXCEL_SHEET_OBJ_P(object); \
		sheet = obj->sheet; \
		book = obj->book; \
		if (!sheet) { \
			zend_throw_exception(excel_ce_exception, "The sheet wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define FONT_FROM_OBJECT(font, object) \
	{ \
		excel_font_object *obj = Z_EXCEL_FONT_OBJ_P(object); \
		font = obj->font; \
		if (!font) { \
			zend_throw_exception(excel_ce_exception, "The font wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define FORMAT_FROM_OBJECT(format, object) \
	{ \
		excel_format_object *obj = Z_EXCEL_FORMAT_OBJ_P(object); \
		format = obj->format; \
		if (!format) { \
			zend_throw_exception(excel_ce_exception, "The format wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#if LIBXL_VERSION >= 0x03070000
#define AUTOFILTER_FROM_OBJECT(autofilter, object) \
	{ \
		excel_autofilter_object *obj = Z_EXCEL_AUTOFILTER_OBJ_P(object); \
		autofilter = obj->autofilter; \
		if (!autofilter) { \
			zend_throw_exception(excel_ce_exception, "The autofilter wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define FILTERCOLUMN_FROM_OBJECT(filtercolumn, object) \
	{ \
		excel_filtercolumn_object *obj = Z_EXCEL_FILTERCOLUMN_OBJ_P(object); \
		filtercolumn = obj->filtercolumn; \
		if (!filtercolumn) { \
			zend_throw_exception(excel_ce_exception, "The filtercolumn wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}
#endif

#if LIBXL_VERSION >= 0x03090000
#define RICHSTRING_FROM_OBJECT(richstring, object) \
	{ \
		excel_richstring_object *obj = Z_EXCEL_RICHSTRING_OBJ_P(object); \
		richstring = obj->richstring; \
		if (!richstring) { \
			zend_throw_exception(excel_ce_exception, "The richstring wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define RICHSTRING_AND_BOOK_FROM_OBJECT(richstring, book, object) \
	{ \
		excel_richstring_object *obj = Z_EXCEL_RICHSTRING_OBJ_P(object); \
		richstring = obj->richstring; \
		book = obj->book; \
		if (!richstring) { \
			zend_throw_exception(excel_ce_exception, "The richstring wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}
#endif

#if LIBXL_VERSION >= 0x04000000
#define FORMCONTROL_FROM_OBJECT(formcontrol, object) \
	{ \
		excel_formcontrol_object *obj = Z_EXCEL_FORMCONTROL_OBJ_P(object); \
		formcontrol = obj->formcontrol; \
		if (!formcontrol) { \
			zend_throw_exception(excel_ce_exception, "The formcontrol wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define FORMCONTROL_AND_BOOK_FROM_OBJECT(formcontrol, book, object) \
	{ \
		excel_formcontrol_object *obj = Z_EXCEL_FORMCONTROL_OBJ_P(object); \
		formcontrol = obj->formcontrol; \
		book = obj->book; \
		if (!formcontrol) { \
			zend_throw_exception(excel_ce_exception, "The formcontrol wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}
#endif

#if LIBXL_VERSION >= 0x04010000
#define CONDFORMAT_FROM_OBJECT(condformat, object) \
	{ \
		excel_condformat_object *obj = Z_EXCEL_CONDFORMAT_OBJ_P(object); \
		condformat = obj->condformat; \
		if (!condformat) { \
			zend_throw_exception(excel_ce_exception, "The conditional format wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define CONDFORMAT_AND_BOOK_FROM_OBJECT(condformat, book, object) \
	{ \
		excel_condformat_object *obj = Z_EXCEL_CONDFORMAT_OBJ_P(object); \
		condformat = obj->condformat; \
		book = obj->book; \
		if (!condformat) { \
			zend_throw_exception(excel_ce_exception, "The conditional format wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define CONDFORMATTING_FROM_OBJECT(condformatting, object) \
	{ \
		excel_condformatting_object *obj = Z_EXCEL_CONDFORMATTING_OBJ_P(object); \
		condformatting = obj->condformatting; \
		if (!condformatting) { \
			zend_throw_exception(excel_ce_exception, "The conditional formatting wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define CONDFORMATTING_AND_BOOK_FROM_OBJECT(condformatting, book, object) \
	{ \
		excel_condformatting_object *obj = Z_EXCEL_CONDFORMATTING_OBJ_P(object); \
		condformatting = obj->condformatting; \
		book = obj->book; \
		if (!condformatting) { \
			zend_throw_exception(excel_ce_exception, "The conditional formatting wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}
#endif

#if LIBXL_VERSION >= 0x04050000
#define COREPROPERTIES_FROM_OBJECT(coreproperties, object) \
	{ \
		excel_coreproperties_object *obj = Z_EXCEL_COREPROPERTIES_OBJ_P(object); \
		coreproperties = obj->coreproperties; \
		if (!coreproperties) { \
			zend_throw_exception(excel_ce_exception, "The core properties object wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}

#define COREPROPERTIES_AND_BOOK_FROM_OBJECT(coreproperties, book, object) \
	{ \
		excel_coreproperties_object *obj = Z_EXCEL_COREPROPERTIES_OBJ_P(object); \
		coreproperties = obj->coreproperties; \
		book = obj->book; \
		if (!coreproperties) { \
			zend_throw_exception(excel_ce_exception, "The core properties object wasn't initialized", 0); \
			RETURN_THROWS(); \
		} \
	}
#endif

/* ----------------------------------------------------------------
   Extern declarations for class entries and object handlers
   ---------------------------------------------------------------- */

extern zend_class_entry *excel_ce_book;
extern zend_class_entry *excel_ce_sheet;
extern zend_class_entry *excel_ce_format;
extern zend_class_entry *excel_ce_font;

#if LIBXL_VERSION >= 0x03070000
extern zend_class_entry *excel_ce_autofilter;
extern zend_class_entry *excel_ce_filtercolumn;
#endif

#if LIBXL_VERSION >= 0x03090000
extern zend_class_entry *excel_ce_richstring;
#endif

#if LIBXL_VERSION >= 0x04000000
extern zend_class_entry *excel_ce_formcontrol;
#endif

#if LIBXL_VERSION >= 0x04010000
extern zend_class_entry *excel_ce_condformat;
extern zend_class_entry *excel_ce_condformatting;
#endif

#if LIBXL_VERSION >= 0x04050000
extern zend_class_entry *excel_ce_coreproperties;
#endif

extern zend_object_handlers excel_object_handlers_book;
extern zend_object_handlers excel_object_handlers_sheet;
extern zend_object_handlers excel_object_handlers_format;
extern zend_object_handlers excel_object_handlers_font;

extern zend_object *excel_object_new_font(zend_class_entry *class_type);

#if LIBXL_VERSION >= 0x03070000
extern zend_object_handlers excel_object_handlers_autofilter;
extern zend_object_handlers excel_object_handlers_filtercolumn;
#endif

#if LIBXL_VERSION >= 0x03090000
extern zend_object_handlers excel_object_handlers_richstring;
extern zend_object *excel_object_new_richstring(zend_class_entry *class_type);
#endif

#if LIBXL_VERSION >= 0x04000000
extern zend_object_handlers excel_object_handlers_formcontrol;
extern zend_object *excel_object_new_formcontrol(zend_class_entry *class_type);
#endif

#if LIBXL_VERSION >= 0x04010000
extern zend_object_handlers excel_object_handlers_condformat;
extern zend_object_handlers excel_object_handlers_condformatting;
extern zend_object *excel_object_new_condformat(zend_class_entry *class_type);
extern zend_object *excel_object_new_condformatting(zend_class_entry *class_type);
#endif

#if LIBXL_VERSION >= 0x04050000
extern zend_object_handlers excel_object_handlers_coreproperties;
extern zend_object *excel_object_new_coreproperties(zend_class_entry *class_type);
#endif

/* ----------------------------------------------------------------
   Registration functions for new classes (defined in separate .c files)
   ---------------------------------------------------------------- */

extern void excel_richstring_register(void);
extern void excel_formcontrol_register(void);
extern void excel_condformat_register(void);
extern void excel_coreprops_register(void);
extern void excel_table_register(void);

/* ----------------------------------------------------------------
   Shared macros for method/class definitions
   ---------------------------------------------------------------- */

#define EXCEL_METHOD(class_name, function_name) \
	PHP_METHOD(Excel ## class_name, function_name)

#define EXCEL_ME(class_name, function_name, arg_info, flags) \
	PHP_ME(Excel ## class_name, function_name, arg_info, flags)

#define REGISTER_EXCEL_CLASS_CONST_LONG(class_name, const_name, value) \
	zend_declare_class_constant_long(excel_ce_ ## class_name, const_name, sizeof(const_name)-1, (long)value);

#endif	/* PHP_EXCEL_H */
