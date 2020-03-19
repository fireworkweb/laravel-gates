<?php

namespace Fireworkweb\Gates\Tests;

use Fireworkweb\Gates\Tests\Policies\PolicyWithGates;
use Fireworkweb\Gates\Tests\Policies\PolicyWithoutGates;
use Fireworkweb\Gates\Tests\Policies\PolicyWithResourceGates;
use Illuminate\Support\Facades\Gate;

class GatesClassesTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('gates.classes', [
            PolicyWithGates::class,
            PolicyWithoutGates::class,
            PolicyWithResourceGates::class,
        ]);
    }

    /** @test */
    public function it_register_gates_classes()
    {
        $this->assertTrue(true);

        $gates = [
            'policy.index',
            'policy.show',
            'policy_resource.index',
            'policy_resource.create',
            'policy_resource.store',
            'policy_resource.show',
            'policy_resource.edit',
            'policy_resource.update',
            'policy_resource.destroy',
        ];

        $this->assertSame($gates, array_keys(Gate::abilities()));
    }
}
