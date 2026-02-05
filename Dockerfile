# Dockerfile для сборки и тестирования php_excel на разных версиях PHP
# Использование: docker build --build-arg PHP_VERSION=8.3 -t php_excel_test .
#
# Требуется скачать LibXL с https://www.libxl.com/ и положить в директорию libxl/

ARG PHP_VERSION=8.3

FROM --platform=linux/amd64 php:${PHP_VERSION}-cli

# Лицензия LibXL (опционально)
ARG LIBXL_LICENSE_NAME=""
ARG LIBXL_LICENSE_KEY=""

# Установка зависимостей для сборки PHP-расширений
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    autoconf \
    gcc \
    g++ \
    make \
    && rm -rf /var/lib/apt/lists/*

# Копирование LibXL (должен быть скачан вручную с libxl.com)
# Ожидается структура: libxl/include_c/ и libxl/lib64/
COPY libxl /opt/libxl

# Настройка путей к библиотеке
RUN ln -sf /opt/libxl/lib64/libxl.so /usr/lib/libxl.so && ldconfig

# Проверка библиотеки
RUN ls -la /opt/libxl/lib64/ && nm -D /opt/libxl/lib64/libxl.so | grep -i xlCreateBook || echo "xlCreateBook not found"

# Копирование исходников расширения
WORKDIR /usr/src/php_excel
COPY . .

# Сборка расширения
ENV LD_LIBRARY_PATH=/opt/libxl/lib64:$LD_LIBRARY_PATH
RUN phpize \
    && ./configure \
        --with-excel \
        --with-libxl-incdir=/opt/libxl/include_c \
        --with-libxl-libdir=/opt/libxl/lib64 \
    && make \
    && make install \
    && echo "extension=excel.so" > /usr/local/etc/php/conf.d/excel.ini

# Добавление лицензии в php.ini (если указана)
RUN if [ -n "$LIBXL_LICENSE_NAME" ]; then \
        echo "excel.license_name=$LIBXL_LICENSE_NAME" >> /usr/local/etc/php/conf.d/excel.ini; \
    fi && \
    if [ -n "$LIBXL_LICENSE_KEY" ]; then \
        echo "excel.license_key=$LIBXL_LICENSE_KEY" >> /usr/local/etc/php/conf.d/excel.ini; \
    fi

# Проверка загрузки расширения
RUN php -m | grep -i excel

# Запуск тестов по умолчанию
CMD ["make", "test", "NO_INTERACTION=1"]
