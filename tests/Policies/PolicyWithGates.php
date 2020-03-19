<?php

namespace Fireworkweb\Gates\Tests\Policies;

use Fireworkweb\Gates\Traits\HasGates;

class PolicyWithGates
{
    use HasGates;

    protected static function gateRouteName(): string
    {
        return 'policy';
    }

    protected static function gateAbilities(): array
    {
        return [
            'index' => 'index',
            'show' => 'show',
        ];
    }
}
