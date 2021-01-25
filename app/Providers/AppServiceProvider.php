<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Jokes\JokesInterface;
use App\Jokes\Jokes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JokesInterface::class, Jokes::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
