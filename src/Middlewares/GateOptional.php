<?php

namespace Fireworkweb\Gates\Middlewares;

class GateOptional extends Gate
{
    protected function noGate($routeName)
    {
        if (config('middleware.gate_optional.log_no_gates')) {
            logger()->info(
                "[fireworkweb/laravel-gates] No matching gate for '{$routeName}' route."
            );
        }
    }
}
