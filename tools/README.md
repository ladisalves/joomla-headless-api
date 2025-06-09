# Joomla Headless API Tools

This directory provides a Docker image used to generate the `openapi.yaml`
file without installing PHP locally.

## Build the generator image

Run from within `tools/`:

```bash
podman build -f Dockerfile.generate --security-opt seccomp=unconfined -t php-swagger .
```

## Generate `openapi.yaml`

From the repository root execute:

```bash
podman run --rm --security-opt seccomp=unconfined \
    -v $(pwd):/app php-swagger \
    bash -c "composer install && ./vendor/bin/openapi --output /app/openapi.yaml /app/src/headless-api/"
```

The generated file will appear in the project root and can be served using the
webserver container (`Dockerfile.webserver`) described in the main README.
