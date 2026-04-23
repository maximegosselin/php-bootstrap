<?php

declare(strict_types=1);

use App\ServiceProvider;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Container\ContainerInterface;

return (function (): ContainerInterface {

    /* Set PHP working directory to the application's root */
    chdir(__DIR__);

    /* Initialize the autoloader */
    if (!file_exists('vendor/autoload.php')) {
        throw new RuntimeException('Dependencies not installed.');
    }
    require 'vendor/autoload.php';

    /* Load environment variables */
    $repository = RepositoryBuilder::createWithNoAdapters()
        ->addAdapter(EnvConstAdapter::class)
        ->addWriter(PutenvAdapter::class)
        ->immutable()
        ->make();
    $dotenv = Dotenv::create($repository, __DIR__);
    $dotenv->safeLoad();

    /* Load configuration */
    $config = include('config.php');

    /* Return configured container */
    return new Container()
        ->delegate(new ReflectionContainer(true))
        ->addServiceProvider(new ServiceProvider($config));
})();
