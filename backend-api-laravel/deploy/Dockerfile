
Skip to content
DEV Community
Create account
Cover image for Dockerize a Laravel 11 app
Frank Alvarez
Frank Alvarez

Posted on Jun 28, 2024
82
Dockerize a Laravel 11 app
#docker
#laravel
#php
#nginx

Dockerizing a Laravel application is not as simple as it seems, which is why today I will guide you through the process of creating a Docker image for Laravel 11 in 2024.

To do this, we will configure a complete environment using Docker Compose, ensuring that our Laravel application is ready for deployment in any environment.
1. Create the necessary configuration files

To start, make sure to create the following files in your project:

    ./deploy/docker-compose.yml
    ./deploy/Dockerfile
    ./deploy/nginx.conf
    ./deploy/php.ini
    ./.dockerignore

These files contain the necessary configuration to create the Docker image and manage the containers.

    Using the deploy directory is a personal convention; you can choose any name you prefer. However, make sure the configurations shown below match the path where you saved the files.

1.1 Build the Dockerfile

The Dockerfile defines the development environment for our Laravel application. In this case, we will divide it into two stages: one to build the application and another to run it in production (not necessarily) as follows:

# deploy/Dockerfile

# stage 1: build stage
FROM php:8.3-fpm-alpine as build

# installing system dependencies and php extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    nodejs \
    npm \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd

# install composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy necessary files and change permissions
COPY . .
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# install php and node.js dependencies
RUN composer install --no-dev --prefer-dist \
    && npm install \
    && npm run build

RUN chown -R www-data:www-data /var/www/html/vendor \
    && chmod -R 775 /var/www/html/vendor

# stage 2: production stage
FROM php:8.3-fpm-alpine

# install nginx
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    oniguruma-dev \
    gettext-dev \
    freetype-dev \
    nginx \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif \
    && docker-php-ext-install gettext \
    && docker-php-ext-enable gettext \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \
    && rm -rf /var/cache/apk/*

# copy files from the build stage
COPY --from=build /var/www/html /var/www/html
COPY ./deploy/nginx.conf /etc/nginx/http.d/default.conf
COPY ./deploy/php.ini "$PHP_INI_DIR/conf.d/app.ini"

WORKDIR /var/www/html

# add all folders where files are being stored that require persistence. if needed, otherwise remove this line.
VOLUME ["/var/www/html/storage/app"]

CMD ["sh", "-c", "nginx && php-fpm"]

Remember that if your application has additional PHP extensions, you should add them in this file in the dependency installation section. This might be necessary only in the production stage, but there could be cases where it's required in the build stage.
1.2 Add the docker-compose.yml file

This file defines the services needed to run our Laravel application in Docker. In the following docker-compose.yml, we define the service for our Laravel application, as well as the service for the MySQL database.

    Remember to follow step 2 to create the environment variables, this is very important for your application to work correctly.

# deploy/docker-compose.yml

version: '3.8'

services:
  laravel:
    restart: unless-stopped
    container_name: laravelapp
    build:
      context: ../
      dockerfile: ./deploy/Dockerfile
    # allocate as many volumes as necessary, if needed.
    volumes:
      - ../storage/app:/var/www/html/storage/app
    environment:
      APP_NAME: ${APP_NAME}
      APP_ENV: ${APP_ENV}
      APP_DEBUG: ${APP_DEBUG}
      APP_KEY: ${APP_KEY}
      APP_VERSION: ${APP_VERSION}
      APP_URL: ${APP_URL}
      DB_CONNECTION: mysql
      DB_HOST: database
      DB_PORT: 3306
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}
      MAIL_MAILER: ${MAIL_MAILER}
      MAIL_HOST: ${MAIL_HOST}
      MAIL_PORT: ${MAIL_PORT}
      MAIL_USERNAME: ${MAIL_USERNAME}
      MAIL_PASSWORD: ${MAIL_PASSWORD}
      MAIL_ENCRYPTION: ${MAIL_ENCRYPTION}
      MAIL_FROM_ADDRESS: ${MAIL_FROM_ADDRESS}
      MAIL_FROM_NAME: ${MAIL_FROM_NAME}
    ports:
      - "8080:80"
    networks:
      - n-laravel
    depends_on:
      - database

  database:
    restart: unless-stopped
    image: mariadb:lts-jammy
    volumes:
      - v-database:/var/lib/mysql
    environment:
      MARIADB_DATABASE: ${DB_DATABASE}
      MARIADB_USER: ${DB_USERNAME}
      MARIADB_PASSWORD: ${DB_PASSWORD}
      MARIADB_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
    networks:
      - n-laravel

volumes:
  v-database:


networks:
  n-laravel:
    driver: bridge

In the volume configuration, you can add or remove the volumes you need. In this case, only the volume for the storage/app folder is being added, assuming it might be the only folder needing persistence. Also, if you don't need it, you can remove it.

Similarly, you don't necessarily have to use a directory as a volume; you can use a Docker volume without any problem.
1.3 Nginx server configuration

Next, we configure the nginx.conf file to serve our Laravel application. This file defines the Nginx server configuration and how to handle requests to the application.

# deploy/nginx.conf

server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/html/public;
    client_max_body_size 10M;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico {
        access_log off; log_not_found off;
    }
    location = /robots.txt {
        access_log off; log_not_found off;
    }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

1.4 PHP Configuration

In case you need to configure PHP, you can do it through the php.ini file. As shown in the following example, where the maximum file upload size is set to 10MB.

# deploy/php.ini
upload_max_filesize  = 10M

1.5 Add the .dockerignore file

This file specifies which files or directories should be ignored by Docker when building the image. For example, it would not be appropriate to copy vendor for compatibility, time, etc.

# .dockerignore
/deploy/docker-compose.yml
/deploy/Dockerfile
/.phpunit.cache
/node_modules
/public/build
/public/hot
/public/storage
/public/bucket
/storage/*.key
/vendor
.env
.env.example
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode
.git

2. Environment variable configuration

By default, when creating a Laravel project, a .env file with the necessary environment variables for development is created.

But; in case you don't have it, you must create a .env file in the root of your project and define the necessary environment variables for your application. Here is a link showing an example of what your .env file should look like: https://github.com/laravel/laravel/blob/11.x/.env.example

Among all this configuration, it is important to edit the database settings. Which by default before editing would look like this:

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

And we need to change it to:

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=admin
DB_PASSWORD=admin
DB_ROOT_PASSWORD=root

In this case, we are ignoring the following configurations: DB_CONNECTION, DB_HOST, and DB_PORT. The reason is that these values are already defined in the docker-compose.yml file.

We are also adding: DB_ROOT_PASSWORD, which is vital for the MySQL image to be built correctly, as it requires a password for the root user.

    Remember that these environment variables are sensitive and should not be shared publicly. Additionally, passwords should be secure.

3. Building the Docker image

With everything configured previously, it is time to build the Docker image. For this, we will use the following commands:

1. Build and bring up the containers:

docker compose -f deploy/docker-compose.yml --env-file ./.env up --build

2. Run Laravel migrations:

docker exec -t laravelapp php artisan migrate

3. Run Laravel seeders:

In this step, it is not only enough to run the command, but also if you are using the "fakerphp/faker" library, you need to modify the composer.json file to move the library from the list of development dependencies to the list of production dependencies.

This happens because when creating the image, it is indicated not to install development dependencies and therefore when running the command, it will show an error that it cannot find the library.

Example of how the composer.json file should look:

Before:

{
    "require": {
        ...
    },
    "require-dev": {
        "fakerphp/faker": "^1.23"
    }
}

After:

{
    "require": {
        ...
        "fakerphp/faker": "^1.23"
    },
    "require-dev": {
        ...
    }
}

    It is important to clarify that ... means you may have more dependencies in your file. Therefore, you should not copy them.

And now, we can run the command:

docker exec -t laravelapp php artisan db:seed

4. Configure volumes

    This step only applies if you are using a directory as a volume. If this is not your case, you can skip this step.

As you know, in the Dockerfile we are defining a volume for the storage/app folder of our application. And similarly, within the docker-compose.yml file, the volume is configured as a directory to store persistent files.

However; you may encounter a problem where when writing to this directory, you will likely get a permissions error.

This happens because Nginx does not have sufficient permissions to write to the folder. My solution to this problem is to run the following command to modify and add those permissions:

# first: change group (nginx)
sudo chown -R :81 storage/app
# second: change permissions
sudo chmod -R 775 storage/app

    If you're curious about why the number 81, it's because it is the nginx group ID in Alpine Linux.

5. Access the application

Once you have built the image and brought up the containers using the docker compose command, you can check that your application is working properly in your browser.

Make sure to access the URL http://localhost:8080 and if everything is fine, you will see the home page of your Laravel application.
Conclusion

With these steps, you will have created a Docker image for your Laravel 11 application in 2024. Now you can deploy your application in any environment without worrying about dependencies or server configuration.

It is worth noting that you should carefully verify if you need to add more dependencies in the Dockerfile as well as modify other configurations that may be necessary for your application, both in Nginx, php.ini, and even the version of PHP you are using, it might be necessary to change it.

    Any questions or suggestions, feel free to leave a comment.

Top comments (5)
Subscribe
pic

dunghoangtekos profile image
Tommy Hoang
•
Dec 13 '24 • Edited

I have no idea why I get these messages on building containers:
=> ERROR [stage-1 4/6] COPY ./deploy/nginx.conf /etc/nginx/http.d/default.conf 0.0s
=> ERROR [stage-1 5/6] COPY ./deploy/php.ini /usr/local/etc/php/conf.d/app.ini

failed to solve: failed to compute cache key: failed to calculate checksum of ref ZMK3:6SID:RMVY:VVP6:XYCL:M5YN:UCTJ:EWSY:NFFV:3EOE:DDH5:BXM5::mwy3rtqd6ucn5ha29oswdhb8i: "/deploy/php.ini": not found

Have you tested your Dockerfile?

kareem-khaled profile image
Kareem Khaled
•
Jun 30 '24

Good article on Dockerizing Laravel 11! I was quite interested in your note on being careful with respect to the verification of dependencies and configurations. It reminded me about the challenges of adapting PHP applications for new technologies, like AI.

I wrote an article recently that assessed the relevance of PHP in this age of AI: "PHP in the Age of AI: Don't Overlook This Web Powerhouse for Your Next Smart Project". I will be eager to have your reactions on that now—particularly how containerization, such as Docker, can bring perfect seamless means of integrating PHP with such AI tools.

Would you have a few minutes to check it out and share your feedback? I'm always learning and looking for more discussion at this exciting intersection of technologies!

mdarifulhaque profile image
MD ARIFUL HAQUE
•
Jul 8 '24

Nice article!

dragoonis profile image
Paul Dragoonis
•
Jul 1 '24

    nginx runs as a daemon, in the background, so it's not blocking


chuck_rogers_18e108e78f68 profile image
chuck rogers
•
Nov 24 '24

If I wanted ChatGPT do to this, I would have just asked ChatGPT myself man.
Code of Conduct • Report abuse
Read next
abhay_yt_52a8e72b213be229 profile image
How PHP Session Management Works and How to Handle Session Security

Abhay Singh Kathayat - Dec 26 '24
nolunchbreaks_22 profile image
Containerizing a Three-Tier Application with Docker: A Hands-On Guide

Osagie Anolu - Dec 25 '24
bladearya profile image
Dockerizing Your Frontend Application with Nginx for Seamless Deployment

Amit Kumar Rout - Dec 26 '24
abhay_yt_52a8e72b213be229 profile image
Mastering Unit Testing in PHP: Tools, Frameworks, and Best Practices

Abhay Singh Kathayat - Dec 26 '24
Frank Alvarez
Frontend developer

    Location
    Perú
    Joined
    Oct 6, 2021

Trending on DEV Community
Ben Halpern profile image
Meme Monday
#discuss #watercooler #jokes
ServBay profile image
ServBay v1.7.2 Released: New Node.js Configuration Interface and UX Improvements
#webdev #programming #php #node
Anand Mohan profile image
15 Open-Source Projects to Replace Popular SaaS Tools & Apps 👨‍💻🔥
#opensource #github #saas #productivity

# deploy/Dockerfile

# stage 1: build stage
FROM php:8.3-fpm-alpine as build

# installing system dependencies and php extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    nodejs \
    npm \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd

# install composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy necessary files and change permissions
COPY . .
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# install php and node.js dependencies
RUN composer install --no-dev --prefer-dist \
    && npm install \
    && npm run build

RUN chown -R www-data:www-data /var/www/html/vendor \
    && chmod -R 775 /var/www/html/vendor

# stage 2: production stage
FROM php:8.3-fpm-alpine

# install nginx
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    oniguruma-dev \
    gettext-dev \
    freetype-dev \
    nginx \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath \
    && docker-php-ext-install exif \
    && docker-php-ext-enable exif \
    && docker-php-ext-install gettext \
    && docker-php-ext-enable gettext \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \
    && rm -rf /var/cache/apk/*

# copy files from the build stage
COPY --from=build /var/www/html /var/www/html
COPY ./deploy/nginx.conf /etc/nginx/http.d/default.conf
COPY ./deploy/php.ini "$PHP_INI_DIR/conf.d/app.ini"

WORKDIR /var/www/html

# add all folders where files are being stored that require persistence. if needed, otherwise remove this line.
VOLUME ["/var/www/html/storage/app"]

CMD ["sh", "-c", "nginx && php-fpm"]

Thank you to our Diamond Sponsor Neon for supporting our community.

ALTERNATE UNIVERSE DEV — A constructive and inclusive social network for software developers. With you every step of your journey.

    Home
    DEV++
    Podcasts
    Videos
    Tags
    DEV Help
    Forem Shop
    Advertise on DEV
    DEV Challenges
    DEV Showcase
    About
    Contact
    Free Postgres Database
    Software comparisons

    Code of Conduct
    Privacy Policy
    Terms of use

Built on Forem — the open source software that powers DEV and other inclusive communities.

Made with love and Ruby on Rails. ALTERNATE UNIVERSE DEV © 2016 - 2025.
