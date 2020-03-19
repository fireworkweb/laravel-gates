<?php

namespace Fireworkweb\Gates\Traits;

trait HasGates
{
    protected static function gateRouteName(): string
    {
        // @TODO: add magic way
        return '';
    }

    protected static function gateAbilities(): array
    {
        return [];
    }

    protected static function gateResourceAbilities(): array
    {
        return [
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'show' => 'show',
            'edit' => 'edit',
            'update' => 'update',
            'destroy' => 'destroy',
        ];
    }

    public static function gateRegister(): void
    {
        gate()->resource(
            static::gateRouteName(),
            __CLASS__,
            static::gateAbilities()
        );
    }
}
