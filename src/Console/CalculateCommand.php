<?php

namespace App\Console;

use App\Service\CalculatorInterface;
use App\Service\Operation;
use App\Service\UnallowedOperationException;
use App\Util\FloatUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class CalculateCommand extends Command
{
    private CalculatorInterface $calculator;

    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('calc')
            ->addArgument('n1', InputArgument::REQUIRED)
            ->addArgument('op', InputArgument::REQUIRED)
            ->addArgument('n2', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $n1 = FloatUtil::from($input->getArgument('n1'));
        $op = Operation::tryFrom($input->getArgument('op'));
        $n2 = FloatUtil::from($input->getArgument('n2'));

        try {
            $output->writeln($this->calculator->calculate($n1, $op, $n2));
        } catch (Throwable $t) {
            $output->writeln($t->getMessage());
            exit - 1;
        }

        return 0;
    }
}
