<?php

namespace App\Web;

use App\Service\CalculatorInterface;
use App\Service\Operation;
use App\Util\FloatUtil;
use Laminas\Diactoros\Response\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class CalcRequestHandler implements RequestHandlerInterface
{
    private CalculatorInterface $calculator;

    public function __construct(CalculatorInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $n1 = FloatUtil::from($request->getQueryParams()['n1'] ?? null);
        $op = Operation::tryFrom($request->getQueryParams()['op'] ?? '');
        $n2 = FloatUtil::from($request->getQueryParams()['n2'] ?? null);

        if (!is_float($n1) || !is_float($n2) || is_null($op)) {
            return new TextResponse('Invalid parameters', 400);
        }

        try {
            $result = $this->calculator->calculate($n1, $op, $n2);
        } catch (Throwable $t) {
            return new TextResponse($t->getMessage(), 400);
        }

        return new TextResponse((string)$result);
    }
}
