FROM php:8.3-apache

WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/trilhacode-entrypoint
RUN chmod +x /usr/local/bin/trilhacode-entrypoint \
    && a2enmod headers

EXPOSE 10000
ENTRYPOINT ["trilhacode-entrypoint"]
CMD ["apache2-foreground"]
