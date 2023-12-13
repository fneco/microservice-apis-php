FROM composer:2.6.6

WORKDIR /usr

# https://github.com/PHP-CS-Fixer/PHP-CS-Fixer?tab=readme-ov-file#installation
RUN /usr/bin/composer require --dev friendsofphp/php-cs-fixer

ENTRYPOINT ["/usr/vendor/bin/php-cs-fixer"]
