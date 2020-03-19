<?php

use Illuminate\Contracts\Auth\Access\Gate;

if (! function_exists('gate')) {
    function gate(): Gate
    {
        return app(Gate::class);
    }
}
