# Joomla Headless API

- v1, v2, mdx
- "-c", "vendor/bin/openapi --output /app/openapi.yaml /app/src && tail -f /dev/null"
- # Run Composer to install dependencies
RUN composer install

# Install Swagger-PHP
RUN composer require zircote/swagger-php league/html-to-markdown


Would you like the vendor directory added to your .gitignore [yes]?
PSR-4 autoloading configured. Use "namespace Cr8\JoomlaHeadlessApi;" in src/
Include the Composer autoloader with: require 'vendor/autoload.php';



### Update the swagger file
```bash
podman build --security-opt seccomp=unconfined -t php-swagger .
podman run --security-opt seccomp=unconfined -v $(pwd):/app php-swagger

podman run --security-opt seccomp=unconfined -v $(pwd):/app -ti php-swagger "vendor/bin/openapi --output /app/openapi.yaml /app/src"
```

./vendor/bin/openapi --output openapi.yaml ./src



docker-compose build
docker-compose up
docker-compose up -d

podman build --security-opt seccomp=unconfined -t apache-php .
podman run --security-opt seccomp=unconfined -v $(pwd):/var/www/html -p 8080:80 apache-php

### Running tests

Install the Composer dependencies and execute PHPUnit:

```bash
composer install
vendor/bin/phpunit
```
