
FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql mc \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    wget \
    mc \
&& apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN sed -i "s/memory_limit = 128M/memory_limit = 2048M/" /etc/php/7.2/fpm/php.ini

WORKDIR /var/www/store

EXPOSE 9000
