<?php

namespace Fireworkweb\Gates;

use Fireworkweb\Gates\Commands\RoutesWithoutGate;
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

        $this->commands([
            RoutesWithoutGate::class,
        ]);

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
        $paths = array_filter(config('gates.paths'), function ($path) {
            return is_dir($path);
        });

        $files = ! empty($paths) ? (new Finder)->in($paths)->files() : [];

        collect($files)
            ->map(function ($file) {
                return str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::ucfirst(Str::after($file->getPathname(), realpath(base_path()).DIRECTORY_SEPARATOR))
                );
            })
            ->merge(config('gates.classes'))
            ->unique()
            ->filter(function ($class) {
                return in_array(HasGates::class, class_uses_recursive($class))
                    && ! (new \ReflectionClass($class))->isAbstract();
            })
            ->each(function ($class) {
                $class::gateRegister();
            });
    }
}
