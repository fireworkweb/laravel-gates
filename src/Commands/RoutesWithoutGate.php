<?php

namespace Fireworkweb\Gates\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class RoutesWithoutGate extends Command
{
    protected $signature = 'gates:routes-without-gate
                            {middleware=gate : The middleware name.}';

    protected $description = 'Shows routes without gate that has the middleware.';

    public function handle(Router $router)
    {
        $routes = $router->getRoutes();

        $routesWithoutGate = collect($routes)
            ->filter(function ($route) {
                return $this->hasMiddleware($route) && ! $this->hasGate($route);
            })
            ->map(function ($route) {
                return [$route->getName() ?: $route->getPrefix()];
            });

        if ($routesWithoutGate->isEmpty()) {
            $this->info('Great job, no routes without gate. :)');

            return 0;
        } else {
            $this->error('You got routes without gate, see list below:');
            $this->table(['Route'], $routesWithoutGate->all());

            return 1;
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
