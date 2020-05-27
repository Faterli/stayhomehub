<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \App\Models\Meta::observe(\App\Observers\MetaObserver::class);
        \App\Models\View::observe(\App\Observers\ViewObserver::class);
        \App\Models\Video::observe(\App\Observers\VideoObserver::class);
        \App\Models\News::observe(\App\Observers\NewsObserver::class);
    }
}
