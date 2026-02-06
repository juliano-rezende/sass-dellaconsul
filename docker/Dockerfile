# Usa a imagem base PHP
ARG PHP_VERSION=8.4-fpm-bookworm
FROM php:${PHP_VERSION}

## Diretório da aplicação
ARG APP_DIR=/var/www/app
WORKDIR $APP_DIR


# Instalação de pacotes essenciais no sistema operacional
RUN apt-get update -y && apt-get install -y --no-install-recommends \
    apt-utils \
    supervisor \
    zlib1g-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libpq-dev \
    libxml2-dev \
    nginx \
    cron \
    ca-certificates \
    openssl \
    bzip2 \
    gzip \
    rsync \
    lsof \
    htop \
    nano \
    git && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalação de extensões do PHP
RUN docker-php-ext-install \
    session \
    xml \
    zip \
    iconv \
    simplexml \
    pcntl \
    gd \
    fileinfo \
    pdo \
    pdo_mysql \
    mysqli

# Instalação do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Configuração do NGINX
RUN rm -rf /etc/nginx/sites-enabled/* /etc/nginx/sites-available/* /etc/nginx/nginx.conf
COPY --chown=www-data:www-data ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --chown=www-data:www-data ./docker/nginx/sites.conf /etc/nginx/conf.d/default.conf


# Configuração do PHP-FPM
COPY --chown=www-data:www-data ./docker/php/extra-php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY --chown=www-data:www-data ./docker/php/extra-php.ini "$PHP_INI_DIR/extra-php.ini"


# Configuração do Supervisor
COPY --chown=www-data:www-data ./docker/supervisord/conf.d  /etc/supervisor/conf.d


# Configuração do Crontab
COPY --chown=www-data:www-data ./docker/crontab /var/spool/cron/crontabs


# Copiando aplicação para dentro do container
COPY --chown=www-data:www-data . .


# Ajuste de permissões para o usuário www-data
RUN chmod -R 755 $APP_DIR && \
   chown -R www-data:www-data $APP_DIR


# Remoção da pasta vendor para garantir instalação correta
#RUN rm -rf vendor


# Instalação de dependências do Composer
RUN composer install --no-interaction --no-scripts --ignore-platform-reqs --optimize-autoloader


# Limpeza do sistema para reduzir o tamanho da imagem final
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/*


# Definição do alias ll (Mantido conforme solicitado)
RUN echo "alias ll='ls -lh --color=auto'" >> ~/.bashrc


# Inicialização do Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
