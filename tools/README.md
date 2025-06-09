# Joomla Headless API Tools

I don't have PHP installed on my local machine, so I'm using a container to manage Composer and generate the Swagger file.

## Docker

### Build the container
```bash
podman build --security-opt seccomp=unconfined -t php-swagger .
```

### Run the container
```bash
podman run --security-opt seccomp=unconfined -v $(pwd):/app -ti php-swagger bash
```

### Composer install
```bash
podman run --security-opt seccomp=unconfined -v $(pwd):/app php-swagger composer install
```

### Update the swagger file
```bash
podman run --security-opt seccomp=unconfined -v $(pwd):/app -ti php-swagger bash -c ./vendor/bin/openapi --output openapi.yaml ./src/headless-api/
```
