<?php

namespace App\Providers;


use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EvaluationCycleRepository;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\IEmployeeRepository;
use App\Repositories\Interfaces\IEvaluationCycleRepository;
use App\Repositories\Interfaces\IPlantRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\PlantRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IEvaluationCycleRepository::class, EvaluationCycleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
