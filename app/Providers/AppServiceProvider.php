<?php

namespace App\Providers;

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
            'App\Services\HttpClient\HttpClient',
            'App\Services\HttpClient\GuzzleHttpClient'
        );

        $this->app->bind(
            'App\Domain\Repository\CommentRepositoryInterface',
            'App\Domain\Repository\CommentRepository'
        );
    }
}
