FROM php:7.2-fpm

ARG USERID=1000

RUN usermod -u $USERID www-data && \
    mkdir -p /var/www && \
    chown -R www-data:www-data /var/www && \
    chmod 777 -R /var/www

RUN apt-get -qq update --fix-missing \
    && apt-get -q install -y \
        zlib1g-dev \
        libicu-dev \
        g++ \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libxml2-dev \
        libxslt1-dev \
        libc-client-dev \
        libkrb5-dev \
        cloc \
        git-core

COPY docker/runner/php/docker-php-pecl-install /usr/local/bin/

COPY --from=composer:latest /usr/bin/composer /usr/sbin/composer

RUN docker-php-ext-configure imap --with-imap-ssl --with-kerberos \
    && docker-php-ext-install zip iconv intl mysqli gd mbstring pdo_mysql xsl opcache imap bcmath soap

RUN docker-php-pecl-install apcu \
    && docker-php-ext-enable apcu

RUN apt-get install -y libmagickwand-6.q16-dev --no-install-recommends \
    && ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin \
    && pecl install imagick \
    && echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-pecl-install xdebug

RUN pear channel-discover pear.phing.info && \
    pear install --alldeps phing/phing

COPY docker/runner/php/php.ini /usr/local/etc/php/
COPY docker/runner/php/entrypoint.sh /entrypoint.sh

VOLUME /var/www
WORKDIR /var/www
USER www-data

ENTRYPOINT ["/bin/bash", "/entrypoint.sh"]