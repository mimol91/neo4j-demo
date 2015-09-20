FROM ubuntu:14.04

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get -yq install \
        curl \
        apache2 \
        libapache2-mod-php5 \
        php5-mysql \
        php5-gd \
        php5-curl \
        php5-xdebug \
        php5-intl \
        php5-mysql \
        php5-sqlite \
        php-pear \
        vim \
        php-apc && \
    rm -rf /var/lib/apt/lists/*

ADD virtual-host.conf /etc/apache2/sites-enabled/000-default.conf


RUN locale-gen en_US.UTF-8
RUN dpkg-reconfigure locales

# Configure /app folder with sample app
RUN mkdir -p /app && rm -fr /var/www/html
RUN a2enmod rewrite

RUN ln -s /app/web /var/www/html

# Configure xdebug setting and add memory
RUN echo 'xdebug.remote_enable = 1' >> /etc/php5/apache2/conf.d/20-xdebug.ini && \
    echo 'xdebug.remote_connect_back = 1' >> /etc/php5/apache2/conf.d/20-xdebug.ini && \
    sed -i 's/memory_limit =.*/memory_limit = 2048M/' /etc/php5/apache2/php.ini && \
    sed -i 's/upload_max_filesize =.*/upload_max_filesize = 1024M/' /etc/php5/apache2/php.ini && \
    sed -i 's/post_max_size =.*/post_max_size = 1024M/' /etc/php5/apache2/php.ini

EXPOSE 80

WORKDIR /app

CMD ["apache2ctl", "-D", "FOREGROUND"]
