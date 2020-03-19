<?php

use Illuminate\Contracts\Auth\Access\Gate;

if (! function_exists('gate')) {
    /**
     * @return string|null
     */
    function gate()
    {
        return app(Gate::class);
    }
}
