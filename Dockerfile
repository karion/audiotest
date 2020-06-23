FROM php:7.3-fpm-alpine

ENV PROJECT_PATH /app

RUN apk add --update openssl-dev zlib-dev libzip-dev icu icu-libs icu-dev bash git curl netcat-openbsd g++ zip make nodejs npm \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip  intl \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/cache/apk/*

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.9.4

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.default_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini && \
    echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini


RUN echo "memory_limit = -1" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

RUN adduser --system --group --shell /bin/sh user
USER user

RUN mkdir -p $PROJECT_PATH
WORKDIR $PROJECT_PATH

EXPOSE 9000
