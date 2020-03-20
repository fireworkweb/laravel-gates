<?php

namespace Fireworkweb\Gates\Tests;

use Fireworkweb\Gates\Middlewares\Gate;
use Fireworkweb\Gates\Tests\Policies\PolicyWithGates;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

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

        $exitCode = Artisan::call('gates:routes-without-gate', [
            'middleware' => Gate::class,
        ]);

        $output = Artisan::output();

        $this->assertSame(0, $exitCode);
        $this->assertTrue(Str::contains($output, 'Great job, no routes without gate. :)'));
    }

    /** @test */
    public function it_can_see_a_route_without_gate()
    {
        $this->app['router']->get('something', function () {
            return 'yay';
        })->name('something.index')->middleware(Gate::class);

        $exitCode = Artisan::call('gates:routes-without-gate', [
            'middleware' => Gate::class,
        ]);

        $output = Artisan::output();

        $this->assertSame(1, $exitCode);
        $this->assertTrue(Str::contains($output, 'You got routes without gate, see list below:'));
        $this->assertTrue(Str::contains($output, 'something.index'));
    }
}
