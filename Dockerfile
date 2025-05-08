# Use a imagem oficial do PHP como base
FROM php:8.1-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Copiar o banco de dados para o contêiner
COPY ./usuarios.db /var/www/html/usuarios.db

# Expõe a porta 80, que é a porta padrão para o Apache
EXPOSE 80