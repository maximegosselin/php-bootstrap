<?php

namespace Test;

use App\Service\CalculatorInterface;
use App\Service\Operation;
use DivisionByZeroError;
use PHPUnit\Framework\Attributes\Test;

class CalculatorTest extends BaseTestCase
{
    private CalculatorInterface $calculator;

    public function setUp(): void
    {
        parent::setUp();
        $this->calculator = $this->container->get(CalculatorInterface::class);
    }

    #[Test]
    public function add(): void
    {
        $this->assertEquals(
            4 + 6,
            $this->calculator->calculate(4, Operation::ADD, 6),
        );
    }

    #[Test]
    public function subtract(): void
    {
        $this->assertEquals(
            4 - 6,
            $this->calculator->calculate(4, Operation::SUBTRACT, 6),
        );
    }

    #[Test]
    public function multiply(): void
    {
        $this->assertEquals(
            4 * 6,
            $this->calculator->calculate(4, Operation::MULTIPLY, 6),
        );
    }

    #[Test]
    public function divide(): void
    {
        $this->assertEquals(
            4 / 6,
            $this->calculator->calculate(4, Operation::DIVIDE, 6),
        );
    }

    #[Test]
    public function divide_by_zero(): void
    {
        $this->expectException(DivisionByZeroError::class);
        $this->calculator->calculate(1, Operation::DIVIDE, 0);
    }
}
