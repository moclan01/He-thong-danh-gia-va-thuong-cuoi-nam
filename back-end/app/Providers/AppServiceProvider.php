<?php

namespace App\Providers;


use App\Repositories\AccountRepository;
use App\Repositories\CriteriaFormRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EvaluationCriteriaRepository;
use App\Repositories\EvaluationCycleRepository;
use App\Repositories\Interfaces\IAccountRepository;
use App\Repositories\Interfaces\ICriteriaFormRepository;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\IEmployeeRepository;
use App\Repositories\Interfaces\IEvaluationCriteriaRepository;
use App\Repositories\Interfaces\IEvaluationCycleRepository;
use App\Repositories\Interfaces\IOperationRepository;
use App\Repositories\Interfaces\IPlantRepository;
use App\Repositories\Interfaces\IPositionRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\OperationRepository;
use App\Repositories\PlantRepository;
use App\Repositories\PositionRepository;
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
        $this->app->bind(IOperationRepository::class, OperationRepository::class);
        $this->app->bind(IPositionRepository::class, PositionRepository::class);
        $this->app->bind(IEmployeeRepository::class, EmployeeRepository::class);
        $this->app->bind(IEvaluationCycleRepository::class, EvaluationCycleRepository::class);
        $this->app->bind(IAccountRepository::class, AccountRepository::class);
        $this->app->bind(ICriteriaFormRepository::class, CriteriaFormRepository::class);
        $this->app->bind(IEvaluationCriteriaRepository::class, EvaluationCriteriaRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
