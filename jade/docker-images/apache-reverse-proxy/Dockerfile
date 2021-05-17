FROM php:7.4-apache

COPY apache2-foreground /usr/local/bin/

RUN apt-get update && \ 
   apt-get install -y nano


COPY conf/ /etc/apache2
COPY template /var/apache2/templates

RUN a2enmod proxy proxy_http
RUN a2ensite 000-* 001-*