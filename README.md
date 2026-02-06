# libxl_php8 - PHP Extension for LibXL

PHP extension for reading and writing Excel files using the [LibXL](http://www.libxl.com/) library.

## About This Fork

This is a modernized fork with **full PHP 8.x support** and compatibility with **LibXL 5.x**.

**Minimum requirement: PHP 8.2.** For older PHP versions use the repositories of the previous authors (see below).

### Changes in This Fork

- **PHP 8.x Compatibility:**
  - Added `zend_bool` typedef for PHP 8 (uses native `bool`)
  - Replaced deprecated `z/` specifier in `zend_parse_parameters` with `z` + `ZVAL_DEREF`
  - Fixed object memory allocation using `zend_object_alloc()` (PHP 7.3+)
  - Replaced deprecated `zval_dtor()` with `zval_ptr_dtor()`
  - Added `PHP_FE_END` macro for function entry terminators
  - Switched from `E_WARNING` to `ExcelException`
  - Added XLSX format checks for XLSX-only features
  - Memory safety fixes (writeError NULL check, ZVAL_UNDEF)
  - Named constants for formatting limits

- **LibXL 5.x Compatibility:**
  - Fixed `const char**` type incompatibility in `xlFilterColumnGetCustomFilter`

- **Docker Support:**
  - Added `Dockerfile` for building and testing
  - Added `docker-compose.yml` for multi-version PHP testing (8.3, 8.4)

### Migration performed by

**Claude** (Anthropic AI Assistant) - code analysis, PHP 8 migration, LibXL 5.x compatibility fixes, Docker configuration.

---

## Original Authors & Repositories

This project is based on the work of many contributors:

| Author | Contribution |
|--------|-------------|
| **[Ilia Alshanetsky](https://github.com/iliaal)** | Original author, main development |
| **[Johannes Mueller](https://github.com/johmue)** | Major contributor |
| **[Jan Ehrhardt](https://github.com/Jan-E)** | PHP 7/8 support, maintenance |
| **[doPhp](https://github.com/doPhp)** | Excel extension fork |
| **Philip Hofstetter** | Contributions |
| **Stephan Fischer** | Contributions |
| **Pierre Joye** | Contributions |
| **Sebastian Brandt** | Contributions |

### Original Repositories

- **Original:** https://github.com/iliaal/php_excel
- **PHP 7/8 Fork:** https://github.com/Jan-E/php_excel
- **doPhp Fork:** https://github.com/doPhp/excel

---

## Requirements

- PHP 8.2+
- [LibXL](http://www.libxl.com/) 3.6.0+ (commercial library)

## Installation

### Using Docker (Recommended for Testing)

```bash
# Download LibXL for Linux
curl -L -o libxl.tar.gz "https://www.libxl.com/download/libxl-lin-5.1.0.tar.gz"
tar -xzf libxl.tar.gz
mv libxl-5.1.0 libxl
rm libxl.tar.gz

# Build and test on PHP 8.2
docker compose build php82
docker compose up php82

# Test on all PHP versions
docker compose build
docker compose up
```

### Manual Build (Linux/macOS)

```bash
# Clone repository
git clone https://github.com/YOUR_USERNAME/libxl_php8.git
cd libxl_php8

# Build extension
phpize
./configure \
    --with-excel \
    --with-libxl-incdir=/path/to/libxl/include_c \
    --with-libxl-libdir=/path/to/libxl/lib64

make
make install

# Enable extension
echo "extension=excel.so" >> /path/to/php.ini
```

### Build Options

| Platform | Library Directory |
|----------|------------------|
| Linux x86_64 | `lib64` |
| Linux ARM64 | `lib-aarch64` |
| Linux ARM32 | `lib-armhf` |
| Linux x86 | `lib` |
| macOS | `lib` |

## Quick Start

```php
<?php
// Create new Excel workbook (xlsx format)
$book = new ExcelBook(null, null, true);
$book->setLocale('UTF-8');

// Add a sheet
$sheet = $book->addSheet('Sheet1');

// Write data
$sheet->write(0, 0, 'Hello');
$sheet->write(0, 1, 'World');
$sheet->write(1, 0, 42);
$sheet->write(1, 1, 3.14);

// Write formula
$sheet->write(2, 0, '=A2+B2');

// Save file
$book->save('example.xlsx');
```

## Configuration (php.ini)

```ini
[excel]
; License credentials (optional, for licensed LibXL)
excel.license_name="YOUR_LICENSE_NAME"
excel.license_key="YOUR_LICENSE_KEY"

; Skip empty cells when writing (0=no, 1=skip null, 2=skip null and empty strings)
excel.skip_empty=0
```

## Documentation

- See `docs/` directory for API documentation
- See `tests/` directory for usage examples
- [LibXL C API Documentation](http://www.libxl.com/documentation.html)

## Testing

```bash
# Run tests
make test

# Run tests with license
make test TESTS="-d excel.license_name=NAME -d excel.license_key=KEY"
```

## License

PHP License 3.01 - see [LICENSE](http://www.php.net/license/3_01.txt)

LibXL is a commercial library - see [libxl.com](http://www.libxl.com/) for licensing.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests: `docker compose up php82`
5. Submit a pull request

## Known Issues

- **Formulas:** LibXL stores only formulas, not calculated values. Open and save in Excel to calculate.
- **Trial version:** Some features may be limited without a LibXL license.

## Links

- [LibXL Official Website](http://www.libxl.com/)
- [Original php_excel Repository](https://github.com/iliaal/php_excel)
- [Jan-E's PHP 7/8 Fork](https://github.com/Jan-E/php_excel)
- [doPhp's Excel Fork](https://github.com/doPhp/excel)
