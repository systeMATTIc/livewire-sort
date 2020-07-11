<?php

namespace Systemattic\LivewireSort;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Systemattic\LivewireSort\Components\Sort;

class LivewireSortServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('sort', Sort::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'livewire-sort');

        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('livewire_sort.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'livewire_sort');
    }
}
