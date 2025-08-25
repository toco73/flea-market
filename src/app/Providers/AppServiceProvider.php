<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Responses\RegisterResponse as CustomRegisterResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RegisterResponse::class,CustomRegisterResponse::class);
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
