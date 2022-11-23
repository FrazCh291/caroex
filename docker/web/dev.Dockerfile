FROM php:8.0-fpm
ARG FQDNDEV
# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/$FQDNDEV/

# Set working directory
WORKDIR /var/www/$FQDNDEV

ENV EXT_MONGODB_VERSION=1.9.0

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    nano \
    procps \
    libpq-dev\
    grep \
    python3-pip \
    python3 \
    sudo \
    supervisor \
    redis-server \
    libpng-dev \
    zlib1g-dev

RUN pip install socket.py
RUN pip install meld3
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN docker-php-ext-install gd

RUN CFLAGS="$CFLAGS -D_GNU_SOURCE" docker-php-ext-install sockets
RUN docker-php-ext-install pdo pdo_pgsql
RUN apt-get install -y libsqlite3-dev
RUN docker-php-ext-install pdo_sqlite \
&& docker-php-ext-enable pdo_sqlite
# Install and enable xDebug
RUN pecl install xdebug-beta
RUN docker-php-ext-enable xdebug

RUN apt update && apt install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap

# Install sockets
#RUN docker-php-ext-install sockets


# Install mongodb extension
RUN docker-php-source extract \
    && apt-get update && apt-get install git -y \
    && git clone --branch $EXT_MONGODB_VERSION --depth 1 https://github.com/mongodb/mongo-php-driver.git /usr/src/php/ext/mongodb \
    && cd /usr/src/php/ext/mongodb && git submodule update --init \
    && docker-php-ext-install mongodb

# Prevent error in nginx error.log
RUN touch /var/log/xdebug_remote.log
RUN chmod 777 /var/log/xdebug_remote.log

# Nodejs

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y\
  nodejs

# Insall echo server
RUN npm install -g laravel-echo-server

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN adduser www sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Copy existing application directory contents
COPY . /var/www/$FQDNDEV

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/$FQDNDEV

COPY docker/web/supervisord.conf /etc/supervisor
COPY docker/supervisor/dev.conf.d/ /etc/supervisor/conf.d/

RUN chmod 777 /var/www/$FQDNDEV/storage/logs
# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
