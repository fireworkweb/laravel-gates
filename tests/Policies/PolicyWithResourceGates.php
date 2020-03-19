<?php

namespace Fireworkweb\Gates\Tests\Policies;

use Fireworkweb\Gates\Traits\HasGates;

class PolicyWithResourceGates
{
    use HasGates;

    protected static function gateRouteName(): string
    {
        return 'policy_resource';
    }

    protected static function gateAbilities(): array
    {
        return static::gateResourceAbilities();
    }
}
