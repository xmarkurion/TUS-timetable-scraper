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

RUN apt-get update && \
    apt-get install -y lsb-release apt-transport-https ca-certificates wget && \
    wget -O- https://packages.sury.org/php/apt.gpg | apt-key add - && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

# Install PHP 8.3 and FPM
RUN apt-get update && \
    apt-get install -y \
    php8.3-fpm \
    php8.3-cli \
    php8.3-mysql \
    && apt-get clean

# Install npm (Node.js package manager) using the updated setup script
RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm && \
    npx playwright install-deps chromium

# Install Composer (PHP dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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

