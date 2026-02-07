#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04050000

/* ================================================================
   ExcelCoreProperties
   ================================================================ */

zend_class_entry *excel_ce_coreproperties;
zend_object_handlers excel_object_handlers_coreproperties;

/* ----------------------------------------------------------------
   Object handlers
   ---------------------------------------------------------------- */

static void excel_coreproperties_object_free_storage(zend_object *object)
{
	zend_object_std_dtor(object);
}

static zend_object *excel_object_new_coreproperties_ex(zend_class_entry *class_type, excel_coreproperties_object **ptr)
{
	excel_coreproperties_object *intern;

	intern = zend_object_alloc(sizeof(excel_coreproperties_object), class_type);

	if (ptr) {
		*ptr = intern;
	}

	zend_object_std_init(&intern->std, class_type);
	object_properties_init(&intern->std, class_type);

	intern->std.handlers = &excel_object_handlers_coreproperties;

	return &intern->std;
}

zend_object *excel_object_new_coreproperties(zend_class_entry *class_type)
{
	return excel_object_new_coreproperties_ex(class_type, NULL);
}

/* ----------------------------------------------------------------
   ExcelCoreProperties::__construct()
   ---------------------------------------------------------------- */

EXCEL_METHOD(CoreProperties, __construct)
{
	zend_throw_exception(excel_ce_exception, "ExcelCoreProperties cannot be instantiated directly, use ExcelBook::coreProperties()", 0);
	RETURN_THROWS();
}

/* ----------------------------------------------------------------
   String property get/set pairs
   ---------------------------------------------------------------- */

/* {{{ proto string ExcelCoreProperties::title()
	Returns the title property. */
EXCEL_METHOD(CoreProperties, title)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesTitle(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setTitle(string title)
	Sets the title property. */
EXCEL_METHOD(CoreProperties, setTitle)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetTitle(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::subject()
	Returns the subject property. */
EXCEL_METHOD(CoreProperties, subject)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesSubject(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setSubject(string subject)
	Sets the subject property. */
EXCEL_METHOD(CoreProperties, setSubject)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetSubject(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::creator()
	Returns the creator property. */
EXCEL_METHOD(CoreProperties, creator)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesCreator(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setCreator(string creator)
	Sets the creator property. */
EXCEL_METHOD(CoreProperties, setCreator)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetCreator(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::lastModifiedBy()
	Returns the lastModifiedBy property. */
EXCEL_METHOD(CoreProperties, lastModifiedBy)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesLastModifiedBy(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setLastModifiedBy(string lastModifiedBy)
	Sets the lastModifiedBy property. */
EXCEL_METHOD(CoreProperties, setLastModifiedBy)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetLastModifiedBy(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::created()
	Returns the created date as string. */
EXCEL_METHOD(CoreProperties, created)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesCreated(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setCreated(string created)
	Sets the created date as string. */
EXCEL_METHOD(CoreProperties, setCreated)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetCreated(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::modified()
	Returns the modified date as string. */
EXCEL_METHOD(CoreProperties, modified)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesModified(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setModified(string modified)
	Sets the modified date as string. */
EXCEL_METHOD(CoreProperties, setModified)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetModified(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::tags()
	Returns the tags property. */
EXCEL_METHOD(CoreProperties, tags)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesTags(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setTags(string tags)
	Sets the tags property. */
EXCEL_METHOD(CoreProperties, setTags)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetTags(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::categories()
	Returns the categories property. */
EXCEL_METHOD(CoreProperties, categories)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesCategories(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setCategories(string categories)
	Sets the categories property. */
EXCEL_METHOD(CoreProperties, setCategories)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetCategories(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* {{{ proto string ExcelCoreProperties::comments()
	Returns the comments property. */
EXCEL_METHOD(CoreProperties, comments)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);

	const char *val = xlCorePropertiesComments(coreproperties);
	if (val) {
		RETURN_STRING(val);
	}
	RETURN_EMPTY_STRING();
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setComments(string comments)
	Sets the comments property. */
EXCEL_METHOD(CoreProperties, setComments)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	zend_string *val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "S", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetComments(coreproperties, ZSTR_VAL(val));
}
/* }}} */

/* ----------------------------------------------------------------
   Double property get/set pairs
   ---------------------------------------------------------------- */

/* {{{ proto float ExcelCoreProperties::createdAsDouble()
	Returns the created date as a double (Excel serial date). */
EXCEL_METHOD(CoreProperties, createdAsDouble)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	RETURN_DOUBLE(xlCorePropertiesCreatedAsDouble(coreproperties));
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setCreatedAsDouble(float created)
	Sets the created date as a double (Excel serial date). */
EXCEL_METHOD(CoreProperties, setCreatedAsDouble)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	double val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "d", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetCreatedAsDouble(coreproperties, val);
}
/* }}} */

/* {{{ proto float ExcelCoreProperties::modifiedAsDouble()
	Returns the modified date as a double (Excel serial date). */
EXCEL_METHOD(CoreProperties, modifiedAsDouble)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	RETURN_DOUBLE(xlCorePropertiesModifiedAsDouble(coreproperties));
}
/* }}} */

/* {{{ proto void ExcelCoreProperties::setModifiedAsDouble(float modified)
	Sets the modified date as a double (Excel serial date). */
EXCEL_METHOD(CoreProperties, setModifiedAsDouble)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();
	double val;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "d", &val) == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesSetModifiedAsDouble(coreproperties, val);
}
/* }}} */

/* ----------------------------------------------------------------
   removeAll
   ---------------------------------------------------------------- */

/* {{{ proto void ExcelCoreProperties::removeAll()
	Removes all core properties. */
EXCEL_METHOD(CoreProperties, removeAll)
{
	CorePropertiesHandle coreproperties;
	zval *object = getThis();

	if (zend_parse_parameters_none() == FAILURE) {
		RETURN_THROWS();
	}

	COREPROPERTIES_FROM_OBJECT(coreproperties, object);
	xlCorePropertiesRemoveAll(coreproperties);
}
/* }}} */

/* ================================================================
   Arginfo
   ================================================================ */

ZEND_BEGIN_ARG_INFO_EX(arginfo_CoreProperties___construct, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_CoreProperties_noargs, 0, 0, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_CoreProperties_setString, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(arginfo_CoreProperties_setDouble, 0, 0, 1)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()

/* ================================================================
   Method entries
   ================================================================ */

zend_function_entry excel_funcs_coreproperties[] = {
	EXCEL_ME(CoreProperties, __construct, arginfo_CoreProperties___construct, 0)
	EXCEL_ME(CoreProperties, title, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setTitle, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, subject, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setSubject, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, creator, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setCreator, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, lastModifiedBy, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setLastModifiedBy, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, created, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setCreated, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, modified, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setModified, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, tags, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setTags, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, categories, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setCategories, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, comments, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setComments, arginfo_CoreProperties_setString, 0)
	EXCEL_ME(CoreProperties, createdAsDouble, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setCreatedAsDouble, arginfo_CoreProperties_setDouble, 0)
	EXCEL_ME(CoreProperties, modifiedAsDouble, arginfo_CoreProperties_noargs, 0)
	EXCEL_ME(CoreProperties, setModifiedAsDouble, arginfo_CoreProperties_setDouble, 0)
	EXCEL_ME(CoreProperties, removeAll, arginfo_CoreProperties_noargs, 0)
	PHP_FE_END
};

/* ================================================================
   Class registration
   ================================================================ */

void excel_coreprops_register(void)
{
	zend_class_entry ce;

	INIT_CLASS_ENTRY(ce, "ExcelCoreProperties", excel_funcs_coreproperties);
	excel_ce_coreproperties = zend_register_internal_class_ex(&ce, NULL);
	excel_ce_coreproperties->ce_flags |= ZEND_ACC_FINAL;
	excel_ce_coreproperties->create_object = excel_object_new_coreproperties;

	memcpy(&excel_object_handlers_coreproperties, zend_get_std_object_handlers(), sizeof(zend_object_handlers));
	excel_object_handlers_coreproperties.offset = XtOffsetOf(excel_coreproperties_object, std);
	excel_object_handlers_coreproperties.free_obj = excel_coreproperties_object_free_storage;
	excel_object_handlers_coreproperties.clone_obj = NULL;
}

#else

void excel_coreprops_register(void)
{
	/* noop: LibXL < 4.5.0 */
}

#endif
