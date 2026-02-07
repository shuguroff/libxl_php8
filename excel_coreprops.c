#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04050000

/* ExcelCoreProperties class implementation will be added in Phase 6 */

void excel_coreprops_register(void)
{
	/* TODO: register ExcelCoreProperties class */
}

#else

void excel_coreprops_register(void)
{
	/* noop: LibXL < 4.5.0 */
}

#endif
