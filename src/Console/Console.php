<?php

namespace App\Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class Console extends Application
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->addCommand($container->get(CalculateCommand::class));
    }
}
