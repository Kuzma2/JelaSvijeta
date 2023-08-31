<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\MealRepositoryInterface;
use App\Repositories\MealRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register() 
{
    $this->app->bind(MealRepositoryInterface::class, MealRepository::class);
 }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
