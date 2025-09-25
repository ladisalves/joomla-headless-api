# Installation

This repository contains a standalone set of PHP scripts that expose a headless API for Joomla. The code is not packaged as a Joomla extension, so you simply place the files alongside your Joomla site.

Two common approaches are described below.

## 1. Local Composer

If PHP and Composer are available on your machine:

```bash
# clone the repository
cd /path/to/your/project
git clone <repository-url> headless-api
cd headless-api

# install dependencies without development packages
composer install --no-dev --optimize-autoloader
```

Copy `src/hapi/` (or the generated `vendor/` and API files) to a directory that is **outside** the Joomla core so upgrades do not overwrite it. Update the copied `configuration.php` or `HeadlessApi/database.php` to reference your site's database credentials, or remove `configuration.php` to use the Joomla-wide `JConfig` class.

## 2. Podman / Docker

If you prefer not to install PHP locally you can build a container that performs the installation. The `tools/Dockerfile.distribution` image installs the dependencies and bundles the API into a single archive.

```bash
cd tools
podman build -f Dockerfile.distribution -t joomla-headless-api-dist .
podman run --rm -v $(pwd)/..:/app joomla-headless-api-dist
```

The container produces `joomla-headless-api.zip` inside the project root. Upload the archive next to your Joomla installation and extract it. Point your web server (or a Joomla menu item) to the PHP files in this directory.

You can use `docker` in place of `podman` if desired.
