FROM php:7.4-apache

# CakePHP 3.x に必要なシステムライブラリと PHP 拡張をインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libicu-dev \
        libzip-dev \
        libonig-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" intl pdo_mysql mbstring zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# CakePHP の .htaccess（URL リライト）を有効化
RUN a2enmod rewrite

# Composer をイメージから取得
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
