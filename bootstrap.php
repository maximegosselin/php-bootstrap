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

    // Set the working directory
    chdir(__DIR__);

    // Initialize the autoloader
    require 'vendor/autoload.php';

    // Load configuration
    $repository = RepositoryBuilder::createWithNoAdapters()
        ->addAdapter(EnvConstAdapter::class)
        ->addWriter(PutenvAdapter::class)
        ->immutable()
        ->make();
    Dotenv::create($repository, __DIR__)->safeLoad();
    $config = include('config.php');

    // Build and return the container
    return new Container()
        ->delegate(new ReflectionContainer(true))
        ->addServiceProvider(new ServiceProvider($config));
})();
