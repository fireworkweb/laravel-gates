<?php

namespace Fireworkweb\Gates\Traits;

trait HasGates
{
    public function gateAllows()
    {
        return true;
    }

    public function gateAllowsGuests($user = null)
    {
        return true;
    }

    public function gateDenies()
    {
        return false;
    }

    public function gateDeniesGuests($user = null)
    {
        return false;
    }


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
            static::class,
            static::gateAbilities()
        );
    }
}
