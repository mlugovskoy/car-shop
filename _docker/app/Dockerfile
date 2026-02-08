FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
      wget \
      apt-utils \
      libpq-dev \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      pecl install xdebug-3.3.1 && \
      docker-php-ext-enable xdebug && \
      docker-php-ext-install pdo pdo_pgsql pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN a2enmod rewrite

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./_docker/app/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./_docker/app/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY ./_docker/apache/default.conf /etc/apache2/sites-available/000-default.conf

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Sendmail
RUN apt-get update && \
    apt-get install -y --no-install-recommends ca-certificates curl && \
    rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://go.dev/dl/go1.21.10.linux-amd64.tar.gz' | tar -C /usr/local -xzf -
ENV PATH=/usr/local/go/bin:$PATH
RUN go install github.com/mailhog/mhsendmail@latest
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

RUN usermod -u 1000 www-data

WORKDIR /var/www

