#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04010000

/* ExcelConditionalFormat + ExcelConditionalFormatting class implementation will be added in Phase 4 */

void excel_condformat_register(void)
{
	/* TODO: register ExcelConditionalFormat and ExcelConditionalFormatting classes */
}

#else

void excel_condformat_register(void)
{
	/* noop: LibXL < 4.1.0 */
}

#endif
