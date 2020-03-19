<?php

namespace Fireworkweb\Gates;

use Fireworkweb\Gates\Traits\HasGates;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class GatesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/gates.php' => config_path('gates.php'),
        ], 'config');

        $this->loadGates();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/gates.php',
            'gates'
        );
    }

    protected function loadGates()
    {
        $paths = array_filter($this->app->config['gates.paths'], function ($path) {
            return is_dir($path);
        });

        $files = ! empty($paths) ? (new Finder)->in($paths)->files() : [];

        $namespace = $this->app->getNamespace();

        collect($files)
            ->map(function ($file) use ($namespace) {
                return $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($file->getPathname(), realpath(app_path()).DIRECTORY_SEPARATOR)
                );
            })
            ->merge($this->app->config['gates.classes'])
            ->unique()
            ->filter(function ($class) {
                return in_array(HasGates::class, trait_uses_recursive($class));
            })
            ->each(function ($class) {
                $class::gateRegister();
            });
    }
}
