# --- ESTÁGIO 1: COMPILAÇÃO DE ASSETS (NODE) ---
# Usamos uma imagem leve do Node apenas para gerar o CSS/JS
FROM node:18-alpine AS assets-builder
WORKDIR /app
COPY . .
RUN npm install && npm run build

# --- ESTÁGIO 2: SERVIDOR PHP (SUA CONFIGURAÇÃO ORIGINAL) ---
FROM php:8.2-fpm

# 1. Suas dependências de sistema originais
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    cron

# Limpar cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Suas extensões PHP originais
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Instalando o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www

# 4. Copiar o código do projeto
COPY . /var/www

# 5. [NOVIDADE] Copiar os assets compilados lá do Estágio 1
# Isso traz o 'public/build' sem precisar instalar node aqui
COPY --from=assets-builder /app/public/build /var/www/public/build

# 6. Suas configurações de permissão, timezone e dependências
RUN composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 7. Suas configurações de CRON (Mantidas exatamente como as suas)
COPY docker/php/laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron && crontab /etc/cron.d/laravel-cron

# 8. Seu Entrypoint e CMD originais
COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]