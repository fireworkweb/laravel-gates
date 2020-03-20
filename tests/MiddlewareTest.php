<?php

namespace Fireworkweb\Gates\Tests;

use Fireworkweb\Gates\Middlewares\Gate;
use Fireworkweb\Gates\Middlewares\GateOptional;
use Fireworkweb\Gates\Tests\Policies\PolicyWithGates;
use Illuminate\Support\Facades\Log;

class MiddlewareTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('gates.classes', [
            PolicyWithGates::class,
        ]);
    }

    /** @test */
    public function it_can_allow_request()
    {
        $this->app['router']->get('policy', function () {
            return 'yay';
        })->name('policy.accept')->middleware(Gate::class);

        $response = $this->get('policy');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_deny_request()
    {
        $this->app['router']->get('policy', function () {
            return 'yay';
        })->name('policy.deny')->middleware(Gate::class);

        $response = $this->get('policy');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_can_fail_request_without_gate()
    {
        $this->app['router']->get('something', function () {
            return 'yay';
        })->name('something.index')->middleware(Gate::class);

        $response = $this->get('something');

        $response->assertStatus(500);

        $this->assertSame(
            'No matching gate for this route.',
            $response->exception->getMessage()
        );
    }

    /** @test */
    public function it_can_allow_optional_request()
    {
        $this->app['router']->get('policy', function () {
            return 'yay';
        })->name('policy.accept')->middleware(GateOptional::class);

        $response = $this->get('policy');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_candeny_optional_request()
    {
        $this->app['router']->get('policy', function () {
            return 'yay';
        })->name('policy.deny')->middleware(GateOptional::class);

        $response = $this->get('policy');

        $response->assertStatus(403);
    }

    /** @test */
    public function it_can_allow_optional_request_without_gate_and_log()
    {

        $this->app['router']->get('something', function () {
            return 'yay';
        })->name('something.index')->middleware(GateOptional::class);

        Log::shouldReceive('warning')
            ->with("[fireworkweb/laravel-gates] No matching gate for 'something.index' route.");

        $response = $this->get('something');

        $response->assertStatus(200);
    }
}
