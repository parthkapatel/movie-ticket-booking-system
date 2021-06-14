<?php

namespace App\Providers;

use App\Interfaces\BookTicketsInterface;
use App\Interfaces\CastInterface;
use App\Interfaces\CastMoviesInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\MovieDetailsInterface;
use App\Interfaces\MovieReviewInterface;
use App\Interfaces\ReleaseMovieInterface;
use App\Interfaces\TheaterInterface;
use App\Repositories\BookTicketsRepository;
use App\Repositories\CastMoviesRepository;
use App\Repositories\CastRepository;
use App\Repositories\CityRepository;
use App\Repositories\MovieDetailsRepository;
use App\Repositories\MovieReviewRepository;
use App\Repositories\ReleaseMovieRepository;
use App\Repositories\TheaterRepository;
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
        $this->app->bind(BookTicketsInterface::class,BookTicketsRepository::class);
        $this->app->bind(CastMoviesInterface::class,CastMoviesRepository::class);
        $this->app->bind(CastInterface::class,CastRepository::class);
        $this->app->bind(CityInterface::class,CityRepository::class);
        $this->app->bind(MovieDetailsInterface::class,MovieDetailsRepository::class);
        $this->app->bind(ReleaseMovieInterface::class,ReleaseMovieRepository::class);
        $this->app->bind(TheaterInterface::class,TheaterRepository::class);
        $this->app->bind(MovieReviewInterface::class,MovieReviewRepository::class);
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
