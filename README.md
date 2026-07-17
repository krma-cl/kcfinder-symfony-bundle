# KCFinder Symfony Bundle

Official Symfony and Flysystem adapter for [`krma-cl/kcfinder`](https://github.com/krma-cl/kcfinder-Resurrected). It connects a Flysystem storage, Symfony Security and the event dispatcher to KCFinder's framework-independent selector contract.

## Requirements

- PHP 8.2 or newer.
- Symfony 7.4 or 8.x.
- A Flysystem 3 filesystem service.
- A deployed KCFinder browser from `krma-cl/kcfinder`.

## Installation

```bash
composer require krma-cl/kcfinder-symfony-bundle
composer require krma-cl/kcfinder-bootstrap5-theme:^0.3.1
```

Register `Krma\KCFinder\Symfony\KCFinderBundle` when Symfony Flex does not do it for you, then configure the bundle:

```yaml
# config/packages/kcfinder.yaml
kcfinder:
    filesystem_service: 'app.transparency_filesystem'
    url_prefix: '/storage/transparencia'
    security_attribute: 'KCFINDER_SELECT'
    browser_url: '/kcfinder/browse.php'
    theme_directory: 'public/kcfinder/themes'
```

Create a voter for `KCFINDER_SELECT`. Its subject is an array with `operation` and `path`. Resolve a selected file through the manager:

```php
use Krma\KCFinder\Symfony\KCFinderManager;

$file = $manager->select('/01-actos/DO-20130614.pdf');
return $this->json($file);
```

The result contains `name`, `path`, `url`, `mime` and `size`. A `FileSelectedEvent` is dispatched after an authorized selection.

Publish the Composer-installed theme into the application-owned browser
directory without modifying either package under `vendor`:

```bash
php bin/console kcfinder:install-theme
php bin/console kcfinder:install-theme --force
```

The bundle does not copy or publish the legacy browser automatically. Follow
the [core installation guide](https://github.com/krma-cl/kcfinder-Resurrected#installation)
for the browser itself, then expose the configured directory through your
authenticated controller or web deployment.

## Maintenance and community

This official KCFinder integration is maintained by [KRMA](https://krmachile.com) together with its community of users and contributors. KRMA provides development, coordination and infrastructure to support the project's continuity.

## Development

```bash
composer install
composer check
```
