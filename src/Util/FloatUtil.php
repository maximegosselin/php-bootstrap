<?php

declare(strict_types=1);

namespace App\Util;

class FloatUtil
{
    public static function from(mixed $value): ?float
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) ?: null;
    }
}
