# Imagem oficial do PHP com Apache
FROM php:8.2-apache

# Ativa módulos necessários
RUN docker-php-ext-install pdo pdo_sqlite

# Copia os arquivos do projeto para a pasta do Apache
COPY . /var/www/html/

# Dá permissão aos arquivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponha a porta padrão do Apache
EXPOSE 80