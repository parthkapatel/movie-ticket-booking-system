<?php

namespace App\Providers;

use App\Interfaces\CastInterface;
use App\Interfaces\MovieDetailsInterface;
use App\Repositories\CastRepository;
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
        $this->app->bind(CastInterface::class,CastRepository::class);
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
