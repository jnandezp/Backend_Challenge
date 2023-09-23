FROM php:8.2-fpm
RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
                libzip-dev \
                zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install mysqli pdo pdo_mysql \
        && docker-php-ext-install zip

RUN curl --insecure https://getcomposer.org/download/2.5.1/composer.phar -o \
        /usr/bin/composer && chmod +x /usr/bin/composer
