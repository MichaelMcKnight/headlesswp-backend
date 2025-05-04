<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Roots\Acorn\Sage\SageServiceProvider;
use Symfony\Component\Finder\Finder;

class ThemeServiceProvider extends SageServiceProvider
{

    private function autoRegister(string $directory, string $namespace): void
    {
        $path = app_path($directory);

        if (!is_dir($path)) {
            return;
        }

        $files = \Symfony\Component\Finder\Finder::create()
            ->files()
            ->in($path)
            ->name('*.php');

        foreach ($files as $file) {
            $class = $namespace . '\\' . \Illuminate\Support\Str::before($file->getFilename(), '.php');

            if (class_exists($class) && method_exists($class, 'register')) {
                $class::register();
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        add_action('init', function () {
            $this->autoRegister('PostTypes', 'App\\PostTypes');
            $this->autoRegister('Taxonomies', 'App\\Taxonomies');
        });
    }
}
