<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\MakePostType;
use App\Console\Commands\MakeTaxonomy;

class ConsoleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakePostType::class,
                MakeTaxonomy::class,
            ]);
        }
    }
}
