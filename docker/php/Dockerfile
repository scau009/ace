FROM php:8.4-fpm-alpine

ENV TZ=Asia/Shanghai

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd redis xdebug-^3@stable intl mongodb

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 安装必要依赖
RUN apk add --no-cache \
        bash \
        py3-pip \
        supervisor

RUN mkdir -p /etc/supervisor.d /var/log/supervisor

COPY docker/php/supervisord.conf /etc/supervisord.conf
COPY docker/php/entrypoint.sh /etc/entrypoint.sh

# 确保 entrypoint.sh 可执行
RUN chmod +x /etc/entrypoint.sh

WORKDIR /var/www/html

# 可选：提前安装依赖（避免每次容器启动都重新构建 vendor）
# COPY composer.* ./
# RUN composer install --no-scripts --no-interaction

CMD ["php-fpm"]
