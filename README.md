# php-bootstrap

> Article: https://maximegosselin.com/posts/bootstrapping-a-frameworkless-php-application/

A minimal PHP application that can be invoked in four different ways — web, CLI, script, and tests — all sharing a single bootstrap file.

## Requirements

- PHP >= 8.5
- Composer

## Installation

```bash
composer install
```

## The Bootstrap

[`bootstrap.php`](bootstrap.php) is the backbone of the application. Every invocation method starts by requiring it, and gets back a PSR-11 container with access to the full service graph.

It does four things:

1. Sets the working directory to the project root
2. Initializes the autoloader
3. Loads environment variables via [`.env`](.env)
4. Builds and returns the DI container

The rest of the application — web, CLI, script, or tests — is just a different way of consuming that container.

Two implementation details are worth noting.

**`include` can return a value.** `bootstrap.php` wraps everything in an immediately-invoked function expression (IIFE) and returns the container as its result. The caller captures it with a simple assignment:

```php
$container = require 'path/to/bootstrap.php';
```

**The IIFE keeps the global scope clean.** All intermediate variables (`$config`, `$dotenv`, etc.) live inside the anonymous function and are discarded once it returns. Nothing leaks into the global namespace.

## Invocation Methods

### Web

```bash
cd public && php -S localhost:3000
```

Routes are defined in [`public/index.php`](public/index.php). The calculator is exposed at:

```
GET /calc?n1=5&op=add&n2=3
```

This example uses Slim, but any HTTP library or router would work — the container is framework-agnostic.

### CLI

```bash
./console calc 5 add 3
```

Commands are registered in [`src/Console/Console.php`](src/Console/Console.php). This example uses Symfony Console, but anything from a full CLI framework down to `getopt()` would do.

### Script

```bash
php bin/sums.php
```

One line gives you the full service graph:

```php
$container = require __DIR__ . '/../bootstrap.php';
```

From there, pull any service and run your logic. No framework, no boilerplate. See [`bin/sums.php`](bin/sums.php) for a concrete example.

### Tests

```bash
./vendor/bin/phpunit
```

[`tests/BaseTestCase.php`](tests/BaseTestCase.php) bootstraps the container before each test, so tests run against the real service graph.

## Operations

The four operations are toggled independently via environment variables:

| Variable          | Default |
|-------------------|---------|
| `ALLOW_ADD`       | `true`  |
| `ALLOW_SUBTRACT`  | `true`  |
| `ALLOW_MULTIPLY`  | `false` |
| `ALLOW_DIVIDE`    | `true`  |

Disabling an operation throws an [`UnallowedOperationException`](src/Service/UnallowedOperationException.php) at runtime.

Valid `op` values: `add`, `sub`, `mul`, `div` — defined in [`src/Service/Operation.php`](src/Service/Operation.php).
