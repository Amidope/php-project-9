FROM composer

WORKDIR /app

COPY composer* ./

RUN composer install

COPY . .

CMD ["bash", "-c", "make start"]