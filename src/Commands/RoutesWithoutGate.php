<?php

namespace Fireworkweb\Gates\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;

class RoutesWithoutGate extends Command
{
    protected $signature = 'gates:routes-without-gate
                            {middleware=gate : The middleware name.}';

    protected $description = 'Shows routes without gate that has the middleware.';

    public function handle()
    {
        $routes = app('routes')->getRoutes();

        $routesWithoutGate = collect($routes)
            ->filter(function ($route) {
                return $this->hasMiddleware($route) && $this->hasGate($route);
            })
            ->map(function ($route) {
                return $route->getName() ?: $route->getPrefix();
            });

        if ($routesWithoutGate->isEmpty()) {
            $this->info('Great job, no routes without gate. :)');
        } else {
            $this->error('Routes without gate:');
            $this->table(['Route'], $routesWithoutGate->all());
        }
    }

    protected function hasMiddleware(Route $route)
    {
        return in_array($this->argument('middleware'), $route->middleware());
    }

    protected function hasGate(Route $route)
    {
        return gate()->has($route->getName());
    }
}
