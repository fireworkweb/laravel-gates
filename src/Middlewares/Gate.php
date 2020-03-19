<?php

namespace Fireworkweb\Gates\Middlewares;

class Gate
{
    public function handle($request, \Closure $next)
    {
        $route = $request->route();
        $routeName = $route->getName();
        $routeParameters = array_values($route->parameters());

        if (gate()->has($routeName)) {
            gate()->authorize($routeName, $routeParameters);
        } else {
            $this->noGate($routeName);
        }

        return $next($request);
    }

    protected function noGate($routeName)
    {
        throw new \Exception('No matching gate for this route.');
    }
}
