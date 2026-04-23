<?php

namespace App\Service;

interface CalculatorInterface
{
    public function calculate(float $n1, Operation $op, float $n2): float;
}