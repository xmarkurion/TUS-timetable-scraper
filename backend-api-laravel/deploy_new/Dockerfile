# Use the official Debian 12 base image
FROM debian:12

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    unzip \
    gnupg \
    && apt-get clean

# Install PHP 8.3 and FPM
RUN apt-get update && \
    apt-get install -y \
    php8.3-fpm \
    php8.3-cli \
    php8.3-mysql \
    && apt-get clean

# Install npm (Node.js package manager)
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Bun JavaScript runtime
RUN curl -fsSL https://bun.sh/install | bash

# Install Nginx
RUN apt-get update && \
    apt-get install -y nginx && \
    apt-get clean

# Set up the working directory
WORKDIR /var/www/html

# Expose the PHP-FPM and Nginx ports
EXPOSE 9000 80

# Copy the default Nginx configuration file
COPY nginx.conf /etc/nginx/nginx.conf

# Start Nginx and PHP-FPM
CMD ["sh", "-c", "nginx && php-fpm"]
