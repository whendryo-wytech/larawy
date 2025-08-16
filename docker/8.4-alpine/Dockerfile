# Uses the latest Alpine Linux base image
FROM alpine:3.22

# Maintainer
MAINTAINER "Whendryo Nascimento <whendryo@wytech.com.br>"

# Set working directory
ENV DOTNET_ROOT=/usr/share/dotnet
RUN mkdir /app && chmod 775 -R /app
WORKDIR /app
RUN chmod -R 775 /app

##Rmove Old PHP Version
#RUN apk update && apk add bash
#CMD ["tail", "-f", "/dev/null"]

#Update packages and install required dependencies
RUN echo "https://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories
RUN apk update && \
    apk add --no-cache \
    build-base \
    gcompat \
    libaio-dev \
    imagemagick \
    imagemagick-dev \
    libtool \
    autoconf \
    gcc \
    g++ \
    gcc \
    make \
    zlib-dev \
    gcompat \
    libnsl \
    bash \
    curl \
    tar \
    xz \
    redis \
    openssl-dev \
    wget \
    supervisor \
    nginx \
    nano \
    php84 \
    php84-dev \
    php84-pear \
    php84-fpm \
    php84-mbstring \
    php84-xml \
    php84-tokenizer \
    php84-json \
    php84-gd \
    php84-curl \
    php84-openssl \
    php84-session \
    php84-zlib \
    php84-fileinfo \
    php84-dom \
    php84-xmlwriter \
    php84-xmlreader \
    php84-pdo \
    php84-pgsql \
    php84-pdo_pgsql \
    php84-redis \
    php84-pcntl \
    php84-posix \
    php84-pear \
    php84-dev \
    php84-intl \
    php84-xml \
    php84-simplexml \
    php84-bcmath \
    php84-soap \
    php84-xsl \
    php84-sodium \
    php84-opcache \
    php84-phar \
    nodejs \
    npm \
    vsftpd \
    shadow
RUN ln -s /usr/bin/php84 /usr/bin/php
RUN ln -s /usr/bin/pecl84 /usr/bin/pecl
RUN ln -s /usr/bin/pear84 /usr/bin/pear

# [Composer] - Installation
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

#[MSSQL] - Installation
#RUN wget https://download.microsoft.com/download/8/6/8/868e5fc4-7bfe-494d-8f9d-115cbcdb52ae/msodbcsql18_18.1.2.1-1_amd64.apk
#RUN wget https://download.microsoft.com/download/8/6/8/868e5fc4-7bfe-494d-8f9d-115cbcdb52ae/mssql-tools18_18.1.1.1-1_amd64.apk
#RUN apk add --allow-untrusted msodbcsql18_18.1.2.1-1_amd64.apk
#RUN apk add --allow-untrusted mssql-tools18_18.1.1.1-1_amd64.apk
#RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS unixodbc-dev
#RUN pecl install sqlsrv pdo_sqlsrv
#RUN apk del .phpize-deps
#RUN rm msodbcsql18_18.1.2.1-1_amd64.apk
#RUN rm mssql-tools18_18.1.1.1-1_amd64.apk

# [ImageMagick] - Installation
RUN pecl install imagick
RUN sed -i '/disable ghostscript format types/,+6d' /etc/ImageMagick-7/policy.xml

# [Openssl] - Configuration
RUN rm -rf /etc/ssl/openssl.cnf
COPY openssl.cnf /etc/ssl/openssl.cnf

# [PHP] - Configuration
RUN sed -i 's/^post_max_size\s*=.*/post_max_size = 600M/' /etc/php84/php.ini
RUN sed -i 's/^upload_max_filesize\s*=.*/upload_max_filesize = 600M/' /etc/php84/php.ini
RUN sed -i 's/^variables_order\s*=.*/variables_order = EGPCS/' /etc/php84/php.ini
RUN sed -i 's/^hard_timeout\s*=.*/hard_timeout = 360/' /etc/php84/php.ini
RUN sed -i 's/^max_execution_time\s*=.*/max_execution_time = 360/' /etc/php84/php.ini
RUN sed -i 's/^default_socket_timeout\s*=.*/default_socket_timeout = 360/' /etc/php84/php.ini
RUN sed -i 's/^memory_limit\s*=.*/memory_limit = 1024M/' /etc/php84/php.ini
RUN echo "extension=imagick.so" >> /etc/php84/php.ini
RUN echo 'pcov.directory = .' >> /etc/php84/php.ini
RUN echo "" >> /etc/php84/php.ini
RUN echo "; OPcache settings" >> /etc/php84/php.ini
RUN echo "; zend_extension=opcache.so" >> /etc/php84/php.ini
RUN echo "opcache.enable=1" >> /etc/php84/php.ini
RUN echo "opcache.enable_cli=1" >> /etc/php84/php.ini
RUN echo "opcache.validate_timestamps=1" >> /etc/php84/php.ini
RUN echo "opcache.revalidate_freq=0" >> /etc/php84/php.ini
RUN echo "opcache.memory_consumption=256" >> /etc/php84/php.ini
RUN echo "opcache.interned_strings_buffer=16" >> /etc/php84/php.ini
RUN echo "opcache.max_accelerated_files=10000" >> /etc/php84/php.ini
RUN echo "opcache.validate_timestamps=0" >> /etc/php84/php.ini
RUN echo "" >> /etc/php84/php.ini
#RUN echo extension=pdo_sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/10_pdo_sqlsrv.ini
#RUN echo extension=sqlsrv.so >> `php --ini | grep "Scan for additional .ini files" | sed -e "s|.*:\s*||"`/20_sqlsrv.ini

# [Nginx] - Configuration
RUN mkdir -p /run/nginx
COPY nginx.conf /etc/nginx/nginx.conf

# [Cron] - Configuration
RUN mkdir -p /var/log/cron
RUN echo '* * * * * /usr/bin/php /app/artisan schedule:run >> /dev/null 2>&1' | crontab -

# [FTP] - Installation
RUN echo 0
RUN mkdir -p /data/ftp && chown -R ftp:ftp /data/ftp
RUN mkdir -p /app/storage/app/private/scenario && chmod 777 -R /app/storage/app/private/scenario
RUN ln -s /app/storage/app/private/scenario /data/ftp/scenario
COPY vsftpd.conf /etc/vsftpd/vsftpd.conf

# [Supervisor] - Configuration
#RUN echo 0 >> /var/run/cache.txt
RUN mkdir -p /etc/supervisor/conf.d /var/log/supervisor /var/run/supervisor
RUN rm -rf /etc/supervisor/supervisord.conf
COPY supervisord.conf /etc/supervisor/supervisord.conf

# Optimizing Image
RUN apk del gcc musl-dev build-base make g++
RUN rm -rf /var/cache/apk/*
RUN rm -rf /tmp/*

#Permissions
RUN rm -rf /app/storage/tmp && mkdir -p /app/storage/tmp
RUN chmod 777 -R /app/storage/tmp
#RUN chmod 777 -R /app/vendor/dompdf/dompdf/lib/fonts

# Command to be executed when the container starts
RUN mkdir -p /run/sail
COPY start-container.sh /run/sail/start-container.sh
RUN chmod +x /run/sail/start-container.sh
#COPY start-vite.sh /run/sail/start-vite.sh
#RUN chmod +x /run/sail/start-vite.sh
#CMD ["tail", "-f", "/dev/null"]
CMD ["sh","/run/sail/start-container.sh"]
