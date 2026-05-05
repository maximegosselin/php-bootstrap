<?php

declare(strict_types=1);

namespace App;

use App\Service\Calculator;
use App\Service\CalculatorInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function provides(string $id): bool
    {
        return array_key_exists($id, $this->getBindings());
    }

    private function getBindings(): array
    {
        return [
            CalculatorInterface::class => fn() => new Calculator(
                $this->config['allow_add'],
                $this->config['allow_subtract'],
                $this->config['allow_multiply'],
                $this->config['allow_divide'],
            ),
        ];
    }

    public function register(): void
    {
        foreach ($this->getBindings() as $identifier => $resolver) {
            $this->getContainer()->addShared($identifier, $resolver);
        }
    }
}
