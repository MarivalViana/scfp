<?php

namespace App\Providers;

use App\Models\Gasto;
use App\Observers\BaseModelObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // ...

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Correct way: Register the observer for each concrete model.
        Gasto::observe(BaseModelObserver::class);
    }
}
