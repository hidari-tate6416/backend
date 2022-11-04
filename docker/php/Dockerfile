FROM php:7.4-fpm-buster
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# timezone environment
ENV TZ=Asia/Tokyo \
  # locale
  LANG=ja_JP.UTF-8 \
  LANGUAGE=ja_JP:ja \
  LC_ALL=ja_JP.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install wget git libicu-dev libonig-dev libzip-dev unzip locales libpq-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev libreoffice-calc libreoffice-java-common && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen ja_JP.UTF-8 && \
  localedef -f UTF-8 -i ja_JP ja_JP.UTF-8 && \
  mkdir /var/run/php-fpm && \
  docker-php-ext-install intl pdo_mysql zip bcmath && \
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install -j$(nproc) gd && \
  composer config -g process-timeout 3600 && \
  composer config -g repos.packagist composer https://packagist.org

RUN apt update
RUN apt-get install -y xpdf
RUN apt-get install -y imagemagick
RUN apt-get install -y libmagickwand-dev
RUN apt-get install -y vim

RUN pecl install imagick \
  && docker-php-ext-enable imagick


COPY ./docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

RUN cp -p /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
  sed -i -E 's/^(;| )*date\.timezone( )*=.*$/date.timezone = Asia\/Tokyo/g' /usr/local/etc/php/php.ini && \
  sed -i -E 's/^(;| )*upload_max_filesize( )*=.*$/upload_max_filesize = 512M/g' /usr/local/etc/php/php.ini && \
  sed -i -E 's/^(;| )*memory_limit( )*=.*$/memory_limit = 512M/g' /usr/local/etc/php/php.ini && \
  sed -i -E 's/^(;| )*post_max_size( )*=.*$/post_max_size = 512M/g' /usr/local/etc/php/php.ini

WORKDIR /work/backend