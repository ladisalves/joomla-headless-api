# Use the official PHP image as the base image
FROM php:8.4-cli

# Set the working directory
WORKDIR /app

#RUN mkdir -p /var/cache/apt/archives/partial /var/cache/apt/archives

# Install necessary PHP extensions
RUN apt-get update && \
    apt-get install -y \
    build-essential \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php && \
    HASH="$(curl -sS https://composer.github.io/installer.sig)" && \
    php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm -f /tmp/composer-setup.php && \
    chmod +x /usr/local/bin/composer

# Command to generate Swagger documentation and keep the container running
CMD ["sh"]
