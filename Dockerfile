# Dockerfile for building and testing libxl_php8 on different PHP versions
# Usage: docker build --build-arg PHP_VERSION=8.3 -t libxl_php8_test .
#
# Requires downloading LibXL from https://www.libxl.com/ and placing it into the libxl directory

ARG PHP_VERSION=8.3

FROM --platform=linux/amd64 php:${PHP_VERSION}-cli

# Install dependencies for building PHP extensions
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    autoconf \
    gcc \
    g++ \
    make \
    && rm -rf /var/lib/apt/lists/*

# Copy LibXL (must be downloaded manually from libxl.com)
# Expected structure: include_c/ and lib64/
COPY libxl /opt/libxl

# Set up library paths
RUN ln -sf /opt/libxl/lib64/libxl.so /usr/lib/libxl.so && ldconfig

# Verify library
RUN ls -la /opt/libxl/lib64/ && nm -D /opt/libxl/lib64/libxl.so | grep -i xlCreateBook || echo "xlCreateBook not found"

# Copy extension source code
WORKDIR /usr/src/libxl_php8
COPY . .

# Remove local build artifacts (may contain host-specific absolute paths)
# Exclude libxl* directories to preserve libxl.so from the library
RUN rm -f Makefile Makefile.objects Makefile.fragments config.h config.log config.status libtool excel.dep \
    && find . -not -path './libxl*' \( -name '*.lo' -o -name '*.o' -o -name '*.la' -o -name '*.so' -o -name '*.dep' \) -exec rm -f {} + \
    && rm -rf .libs modules autom4te.cache

# Build the extension
ENV LD_LIBRARY_PATH=/opt/libxl/lib64:$LD_LIBRARY_PATH
RUN phpize \
    && ./configure \
        --with-excel \
        --with-libxl-incdir=/opt/libxl/include_c \
        --with-libxl-libdir=/opt/libxl/lib64 \
    && make \
    && make install \
    && echo "extension=excel.so" > /usr/local/etc/php/conf.d/excel.ini

# Verify extension is loaded
RUN php -m | grep -i excel

# Keep optional credentials out of image layers; the container is disposable.
CMD ["sh", "-c", "printf 'excel.license_name=\"%s\"\nexcel.license_key=\"%s\"\n' \"$LIBXL_LICENSE_NAME\" \"$LIBXL_LICENSE_KEY\" > /usr/local/etc/php/conf.d/zz-excel-license.ini && exec make test NO_INTERACTION=1"]
