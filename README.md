# Joomla Headless API

This repository contains an experimental headless API for Joomla CMS. The API
specification is generated using Swagger-PHP and served by a simple Apache
container.

## Serving `openapi.yaml`

The `tools/Dockerfile.webserver` builds an Apache image that exposes the
generated `openapi.yaml` via HTTP. Build and run the container from the
repository root:

```bash
docker build -f tools/Dockerfile.webserver -t joomla-headless-api .
docker run --rm -v $(pwd):/var/www/html -p 8080:80 joomla-headless-api
```

Once running, the specification is available at
`http://localhost:8080/openapi.yaml`.

## Generating the specification

Use the generator image defined by `tools/Dockerfile.generate` to produce the
`openapi.yaml` file before starting the webserver.

## Manual usage inside Joomla

All runtime PHP code now lives under `src/hapi`. Copy this directory into your
Joomla project (for example next to `configuration.php`) and expose the desired
endpoints via your web server or a Joomla menu item. Update the copied
`configuration.php` file to point at your site's database, or delete it to fall
back to Joomla's global `JConfig` definition.

## Running tests

Install the Composer dependencies and execute PHPUnit:

```bash
composer install
vendor/bin/phpunit
```
