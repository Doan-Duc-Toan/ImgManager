<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('ImgManager/livewire/update', $handle);
        });
        Livewire::setScriptRoute(function ($handle) {
            return Route::get('ImgManager/livewire/livewire.js', $handle);
        });
    }
}
