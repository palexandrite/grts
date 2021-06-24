FROM php:8.0
RUN apt-get update -y && apt-get install -y \
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
COPY composer.lock composer.json /app/
USER root
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring zip pcntl
WORKDIR /app
#RUN rm -rf ./vendor
COPY . /app
#RUN rm composer.lock
#RUN composer require laravel/telescope --dev
#RUN composer update
#RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
