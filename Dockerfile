FROM composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
    install-php-extensions pdo_pgsql;

WORKDIR /app

COPY composer* ./

RUN composer install

COPY . .

CMD ["bash", "-c", "make start"]