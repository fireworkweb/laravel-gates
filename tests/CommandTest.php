<?php

namespace Fireworkweb\Gates\Tests;

use Fireworkweb\Gates\Middlewares\Gate;
use Fireworkweb\Gates\Tests\Policies\PolicyWithGates;

class CommandTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('gates.classes', [
            PolicyWithGates::class,
        ]);
    }

    /** @test */
    public function it_can_see_all_routes_with_gate()
    {
        $this->app['router']->get('policy', function () {
            return 'yay';
        })->name('policy.accept')->middleware(Gate::class);

        $this->artisan('gates:routes-without-gate', [
            'middleware' => Gate::class,
        ])
            ->expectsOutput('Great job, no routes without gate. :)')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_see_a_route_without_gate()
    {
        $this->app['router']->get('something', function () {
            return 'yay';
        })->name('something.index')->middleware(Gate::class);

        $this->artisan('gates:routes-without-gate', [
            'middleware' => Gate::class,
        ])
            ->expectsOutput('You got routes without gate, see list below:')
            ->assertExitCode(1);
    }
}
