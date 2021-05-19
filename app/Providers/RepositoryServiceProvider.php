<?php

namespace App\Providers;

use App\Interfaces\MovieDetailsInterface;
use App\Repositories\MovieDetailsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MovieDetailsInterface::class,MovieDetailsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
