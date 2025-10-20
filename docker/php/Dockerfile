FROM php:8.4-fpm-alpine

ENV TZ=Asia/Shanghai

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd redis xdebug-^3@stable intl mongodb

# 建议：开启 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 可选：提前安装依赖（避免每次容器启动都重新构建 vendor）
# COPY composer.* ./
# RUN composer install --no-scripts --no-interaction

CMD ["php-fpm"]
