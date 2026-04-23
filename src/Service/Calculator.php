<?php

declare(strict_types=1);

namespace App\Service;

readonly class Calculator implements CalculatorInterface
{
    public function __construct(
        private bool $allowAdd = true,
        private bool $allowSubtract = true,
        private bool $allowMultiply = true,
        private bool $allowDivide = true,
    )
    {
    }

    public function calculate(float $n1, Operation $op, float $n2): float
    {
        $allowed = match ($op) {
            Operation::ADD => $this->allowAdd,
            Operation::SUBTRACT => $this->allowSubtract,
            Operation::MULTIPLY => $this->allowMultiply,
            Operation::DIVIDE => $this->allowDivide,
        };

        if (!$allowed) {
            throw new UnallowedOperationException('Unallowed operation');
        }

        return match ($op) {
            Operation::ADD => $n1 + $n2,
            Operation::SUBTRACT => $n1 - $n2,
            Operation::MULTIPLY => $n1 * $n2,
            Operation::DIVIDE => $n1 / $n2,
        };
    }
}
