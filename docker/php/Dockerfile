FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libxslt-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libcurl4-openssl-dev \
    pkg-config \
    zip \
    vim \
    sudo \
    cron \
    && apt-get clean

RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    zip \
    gd \
    opcache \
    bcmath \
    mbstring \
    xsl \
    soap

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/AuthService

COPY ./app /var/www/AuthService

RUN composer install --prefer-dist --no-progress --no-suggest --no-interaction

EXPOSE 9000

ENTRYPOINT ["docker-php-entrypoint"]

CMD ["php-fpm"]
