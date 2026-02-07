#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04060000

/* ExcelTable class implementation will be added in Phase 7 */

void excel_table_register(void)
{
	/* TODO: register ExcelTable class */
}

#else

void excel_table_register(void)
{
	/* noop: LibXL < 4.6.0 */
}

#endif
