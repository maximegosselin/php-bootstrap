<?php

declare(strict_types=1);

return (function() {
    $bool = fn(string $var): bool => filter_var(getenv($var) ?? true, FILTER_VALIDATE_BOOL);

    return [
        'allow_add' => $bool('ALLOW_ADD'),
        'allow_subtract' => $bool('ALLOW_SUBTRACT'),
        'allow_multiply' => $bool('ALLOW_MULTIPLY'),
        'allow_divide' => $bool('ALLOW_DIVIDE'),
    ];
})();
