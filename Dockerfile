FROM php:8.0.7-fpm
WORKDIR /app
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    curl \
    openssl \
    git \
    libonig-dev \
    libpq-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
USER root
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
# Install composer
COPY composer.lock composer.json /app/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN php -d memory_limit=-1 composer.phar update
#RUN php -d memory_limit=-1 composer.phar install
COPY . /app
RUN chmod -R 777 /app
RUN rm -rf ./vendor
RUN  composer require --prefer-source  laravel/telescope
RUN php artisan telescope:install
EXPOSE 9000
CMD ["php-fpm"]
