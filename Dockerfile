# Dockerfile для сборки и тестирования php_excel на разных версиях PHP
# Использование: docker build --build-arg PHP_VERSION=8.2 -t php_excel_test .
#
# Требуется скачать LibXL с https://www.libxl.com/ и положить в директорию libxl/

ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-cli

ARG LIBXL_VERSION=4.2.0

# Установка зависимостей для сборки PHP-расширений
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    autoconf \
    gcc \
    g++ \
    make \
    && rm -rf /var/lib/apt/lists/*

# Копирование LibXL (должен быть скачан вручную с libxl.com)
# Ожидается структура: libxl/include_c/ и libxl/lib-aarch64/ (или lib/)
COPY libxl /opt/libxl

# Настройка путей к библиотеке
RUN ln -sf /opt/libxl/lib-aarch64/libxl.so /usr/lib/libxl.so && ldconfig

# Проверка библиотеки
RUN ls -la /opt/libxl/lib-aarch64/ && nm -D /opt/libxl/lib-aarch64/libxl.so | grep -i xlCreateBook || echo "xlCreateBook not found"

# Копирование исходников расширения
WORKDIR /usr/src/php_excel
COPY . .

# Сборка расширения
ENV LD_LIBRARY_PATH=/opt/libxl/lib-aarch64:$LD_LIBRARY_PATH
RUN phpize \
    && ./configure \
        --with-excel \
        --with-libxl-incdir=/opt/libxl/include_c \
        --with-libxl-libdir=/opt/libxl/lib-aarch64 \
    && make \
    && make install \
    && echo "extension=excel.so" > /usr/local/etc/php/conf.d/excel.ini

# Проверка загрузки расширения
RUN php -m | grep -i excel

# Запуск тестов по умолчанию
CMD ["make", "test", "NO_INTERACTION=1"]
