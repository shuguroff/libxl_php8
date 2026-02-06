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
  - Added `docker-compose.yml` for multi-version PHP testing (8.2–8.5)

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
- [LibXL](http://www.libxl.com/) 3.6.0+ (commercial library, trial version available)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/shuguroff/libxl_php8.git
cd libxl_php8
```

### 2a. Using Docker (Recommended for Testing)

Requires [Docker](https://docs.docker.com/get-docker/) with Docker Compose.

```bash
# Download LibXL for Linux (x86_64)
curl -L -o libxl.tar.gz "https://www.libxl.com/download/libxl-lin-5.1.0.tar.gz"
tar -xzf libxl.tar.gz
mv libxl-5.1.0 libxl
rm libxl.tar.gz

# Build and test on a specific PHP version
docker compose build php83
docker compose up php83

# Or test on all PHP versions (8.2, 8.3, 8.4, 8.5)
docker compose build
docker compose up
```

To build with a LibXL license:

```bash
LIBXL_LICENSE_NAME="Your Name" LIBXL_LICENSE_KEY="your-key" docker compose build
docker compose up
```

### 2b. Manual Build on Linux

Install prerequisites:

```bash
# Debian/Ubuntu
sudo apt-get install php-dev libxml2-dev make gcc

# RHEL/CentOS/Fedora
sudo dnf install php-devel libxml2-devel make gcc
```

Download and install LibXL:

```bash
curl -L -o libxl.tar.gz "https://www.libxl.com/download/libxl-lin-5.1.0.tar.gz"
tar -xzf libxl.tar.gz
sudo mv libxl-5.1.0 /opt/libxl
rm libxl.tar.gz

# Make the library available system-wide
sudo ln -sf /opt/libxl/lib64/libxl.so /usr/lib/libxl.so
sudo ldconfig
```

Build and install the extension:

```bash
phpize
./configure \
    --with-excel \
    --with-libxl-incdir=/opt/libxl/include_c \
    --with-libxl-libdir=/opt/libxl/lib64
make
sudo make install
```

Enable the extension:

```bash
# Find your php.ini
php --ini | head -1

# Add the extension (adjust path to your php.ini)
echo "extension=excel.so" | sudo tee /etc/php/conf.d/excel.ini
```

**Library directory by platform:**

| Platform | Directory |
|----------|-----------|
| Linux x86_64 | `lib64` |
| Linux ARM64 | `lib-aarch64` |
| Linux ARM32 | `lib-armhf` |
| Linux x86 | `lib` |

### 2c. Manual Build on macOS

Install prerequisites:

```bash
# If using Homebrew PHP
brew install php

# Or ensure phpize is available
phpize --version
```

Download and extract LibXL for macOS:

```bash
curl -L -o libxl.tar.gz "https://www.libxl.com/download/libxl-mac-5.1.0.tar.gz"
tar -xzf libxl.tar.gz
mv libxl-5.1.0 libxl-mac
rm libxl.tar.gz
```

**Fix the library install name** (required on macOS, otherwise the extension will fail to load silently):

```bash
# Check the current install name (will likely show just "libxl.dylib" without a path)
otool -D libxl-mac/lib/libxl.dylib

# Set the full absolute path as install name
install_name_tool -id "$(pwd)/libxl-mac/lib/libxl.dylib" libxl-mac/lib/libxl.dylib

# Re-sign the library (required after modification on macOS)
codesign -f -s - libxl-mac/lib/libxl.dylib
```

Build the extension:

```bash
phpize
./configure \
    --with-excel \
    --with-libxl-incdir="$(pwd)/libxl-mac/include_c" \
    --with-libxl-libdir="$(pwd)/libxl-mac/lib"
make
```

Verify it loads:

```bash
php -d "extension=$(pwd)/modules/excel.so" -m | grep excel
```

Install:

```bash
# Copy to the PHP extensions directory
cp modules/excel.so "$(php-config --extension-dir)/excel.so"

# Find your php.ini and add the extension
php --ini | head -1
# Add this line to your php.ini:
#   extension=excel.so
```

> **Note:** The absolute path to `libxl-mac/lib/libxl.dylib` is embedded in `excel.so`.
> If you move the `libxl-mac` directory, you will need to rebuild the extension.

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
2. Clone your fork: `git clone https://github.com/<your-username>/libxl_php8.git`
3. Create a feature branch: `git checkout -b my-feature`
4. Make your changes
5. Run tests: `docker compose build php83 && docker compose up php83`
6. Submit a pull request

## Known Issues

- **Formulas:** LibXL stores only formulas, not calculated values. Open and save in Excel to calculate.
- **Trial version:** Some features may be limited without a LibXL license.

## Links

- [LibXL Official Website](http://www.libxl.com/)
- [Original php_excel Repository](https://github.com/iliaal/php_excel)
- [Jan-E's PHP 7/8 Fork](https://github.com/Jan-E/php_excel)
- [doPhp's Excel Fork](https://github.com/doPhp/excel)
