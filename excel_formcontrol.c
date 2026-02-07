#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "libxl.h"
#include "php.h"
#include "php_excel.h"
#include "zend_exceptions.h"

#if LIBXL_VERSION >= 0x04000000

/* ExcelFormControl class implementation will be added in Phase 3 */

void excel_formcontrol_register(void)
{
	/* TODO: register ExcelFormControl class */
}

#else

void excel_formcontrol_register(void)
{
	/* noop: LibXL < 4.0.0 */
}

#endif
