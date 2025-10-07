FROM phalconphp/cphalcon:v5.9.2-php8.4

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# AQUI ESTÁ A MUDANÇA IMPORTANTE
# Altere as permissões do diretório-mãe para o usuário www-data
USER root
RUN set -eux \
    && install-php-extensions memcached \
    && chown -R www-data:www-data /var/www

USER www-data

RUN composer global require phalcon/devtools:"^5.0@dev" --dev

ENV COMPOSER_HOME=/var/www/.composer
ENV PATH="/var/www/.composer/vendor/bin:$PATH"

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]