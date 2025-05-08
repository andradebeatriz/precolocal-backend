FROM php:8.2-cli

# Instala extensões necessárias
RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Copia o projeto para o container
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

# Abre a porta 80
EXPOSE 80

# Inicia servidor PHP embutido
CMD ["php", "-S", "0.0.0.0:80"]
