<?php

declare(strict_types=1);

use App\Service\CalculatorInterface;
use App\Service\Operation;
use Psr\Container\ContainerInterface;

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../bootstrap.php';

/** @var CalculatorInterface $calculator */
$calculator = $container->get(CalculatorInterface::class);

foreach (range(1, 10) as $n1) {
    foreach (range(1, 10) as $n2) {
        echo sprintf('%d + %d = %d', $n1, $n2, $calculator->calculate($n1, Operation::ADD, $n2)) . PHP_EOL;
    }
}
