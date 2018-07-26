FROM php:7.1-fpm-jessie

RUN apt-get update && apt-get install -y gnupg2 wget git zlib1g-dev && \
    echo -n "deb http://apt.postgresql.org/pub/repos/apt/ jessie-pgdg main" >> /etc/apt/sources.list.d/pgdg.list && \
    wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | \
    apt-key add - && \
    apt-get update

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pgsql pdo_pgsql zip

COPY . /www
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl https://getcomposer.org/download/1.6.5/composer.phar -o /www/composer.phar && \
    chmod +x /www/composer.phar && \
    cd /www && \
    /www/composer.phar install && \
    /www/bin/console ckeditor:install --clear=keep && \
    /www/bin/console assets:install --symlink

WORKDIR "/www"
EXPOSE 8000

CMD ["php", "/www/bin/console", "server:run", "0.0.0.0:8000"]