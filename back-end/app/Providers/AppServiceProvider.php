<?php

namespace App\Providers;

use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\IPlantRepository;
use App\Repositories\PlantRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPlantRepository::class, PlantRepository::class);
        $this->app->bind(IDepartmentRepository::class, DepartmentRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
