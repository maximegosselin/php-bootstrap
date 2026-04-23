<?php

declare(strict_types=1);

use App\Web\CalcRequestHandler;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestHandler;

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../bootstrap.php';

/* Create Slim application */
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->addBodyParsingMiddleware();

$app->get('/calc', CalcRequestHandler::class);

$app->run();