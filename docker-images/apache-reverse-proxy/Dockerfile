FROM php:7.4-apache

COPY apache2-foreground /usr/local/bin/

RUN apt-get update && \ 
   apt-get install -y nano


COPY template /var/apache2/templates
COPY conf/ /etc/apache2

RUN a2enmod proxy proxy_http proxy_balancer lbmethod_byrequests headers
RUN a2ensite 000-* 001-*
