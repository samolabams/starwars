<?php

namespace App\Providers;

use Laravel\Lumen\Routing\UrlGenerator;
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
        $this->app->bind(
            'App\Domain\Services\HttpClient\HttpClient',
            'App\Domain\Services\HttpClient\GuzzleHttpClient'
        );
    }

    public function boot(UrlGenerator $url)
    {
        if (env('APP_ENV') === 'prod' || env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
