# Orientación para trabajar en el bundle Symfony

Este repositorio integra KCFinder con Symfony y Flysystem. Lee primero `README.md` y la [guía canónica del ecosistema](https://krma-cl.github.io/kcfinder-docs/roadmap/maintainer-guide).

## Línea base

- Paquete: `krma-cl/kcfinder-symfony-bundle`
- Release estable al crear esta guía: `v1.0.0`
- Requiere PHP 8.2+, Symfony 7.4 u 8, Flysystem 3 y el núcleo KCFinder
- Rama principal: `main`

## Responsabilidad y límites

- Aquí pertenecen configuración del bundle, servicios, Symfony Security, eventos, resolución de URLs y Flysystem.
- No copies ni publiques automáticamente el navegador clásico.
- No dupliques en el bundle reglas neutrales de rutas, metadatos o selector que deban vivir en el núcleo.
- Mantén explícitas las restricciones compatibles del núcleo y Symfony.
- Conserva el descriptor `name`, `path`, `url`, `mime` y `size`, con rutas lógicas y autorización del servidor.

## Validación

```bash
composer install
composer check
```

Prueba una instalación limpia cuando cambien restricciones de Composer. La CI debe cubrir las versiones declaradas de PHP y Symfony.

## Flujo y documentación

- Usa ramas `krma/<descripcion>`.
- Agrega pruebas para contenedor, configuración, Security, almacenamiento y eventos afectados.
- Actualiza `README.md` y `kcfinder-docs` si cambia el mecanismo de instalación o una API pública.
- Publica con SemVer y verifica el tag correspondiente en Packagist.
