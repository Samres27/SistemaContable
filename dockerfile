FROM debian:12-slim

WORKDIR /app
#COPY . .

RUN mkdir -p bootstrap/cache && chmod -R 777 bootstrap/cache
COPY .envDev .env
RUN mkdir -p /app/storage/logs
RUN mkdir -p /database/

RUN apt update \
&& apt install php-common libapache2-mod-php php-cli php-curl php-xml php-gd php-zip php-fpm php-mbstring wget xz-utils php8.2-sqlite3 git -y 
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" && php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& mv composer.phar /usr/local/bin/composer \
&& composer install

RUN php artisan check:migrate

CMD php artisan serve --host="0.0.0.0"
EXPOSE 8000
