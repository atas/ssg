# Set the base image to PHP 7.4 FPM
FROM php:8.2-fpm

# Install some basic utilities and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    nginx \
    node-less \
    git \
    jq \
    procps \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql

# Remove default Nginx configuration
RUN rm -rf /etc/nginx/sites-available/default \
    && rm -rf /etc/nginx/sites-enabled/default

# Copy a new Nginx configuration file into the container
COPY nginx.conf /etc/nginx/sites-available/site.conf
RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/nginx-selfsigned.key -out /etc/nginx/nginx-selfsigned.crt -subj "/C=US/ST=SomeState/L=SomeCity/O=SomeOrganization/OU=SomeOrganizationalUnit/CN=somedomain.com"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

LABEL org.opencontainers.image.source = "https://github.com/atas/ssg"

ENTRYPOINT ["/entrypoint.sh"]
