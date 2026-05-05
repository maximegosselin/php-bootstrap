<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class BaseTestCase extends TestCase
{
    protected ContainerInterface $container;

    public function setUp(): void
    {
        parent::setUp();
        $this->container = include 'bootstrap.php';
    }
}
