<?php

namespace Fireworkweb\Gates\Middlewares;

class GateOptional extends Gate
{
    protected function noGate($routeName)
    {
        logger()->warning(
            "[fireworkweb/laravel-gates] No matching gate for '{$routeName}' route."
        );
    }
}
