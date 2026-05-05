<?php

declare(strict_types=1);

namespace App\Service;

enum Operation: string
{
    case ADD = 'add';
    case SUBTRACT = 'sub';
    case MULTIPLY = 'mul';
    case DIVIDE = 'div';
}
