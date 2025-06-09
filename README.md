# Joomla Headless API

This repository contains an experimental headless API for Joomla CMS. The API
specification is generated using Swagger-PHP and served by a simple Apache
container.

## Serving `openapi.yaml`

The root `Dockerfile` builds an Apache image that exposes the generated
`openapi.yaml` via HTTP. Build and run the container from the repository root:

```bash
docker build -t joomla-headless-api .
docker run --rm -v $(pwd):/var/www/html -p 8080:80 joomla-headless-api
```

Once running, the specification is available at
`http://localhost:8080/openapi.yaml`.

## Generating the specification

Use the generator image located in [`tools/`](tools/README.md) to produce the
`openapi.yaml` file before starting the webserver.

## Running tests

Install the Composer dependencies and execute PHPUnit:

```bash
composer install
vendor/bin/phpunit
```
