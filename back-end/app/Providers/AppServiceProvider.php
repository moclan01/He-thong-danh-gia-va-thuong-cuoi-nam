<?php

namespace App\Providers;


use App\Repositories\AccountRepository;
use App\Repositories\CriteriaFormRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\EvaluationAnswerDetailRepository;
use App\Repositories\EvaluationAnswerRepository;
use App\Repositories\EvaluationCriteriaRepository;
use App\Repositories\EvaluationCycleRepository;
use App\Repositories\EvaluationQuestionRepository;
use App\Repositories\HFormItemRepository;
use App\Repositories\HowFormItemRepository;
use App\Repositories\HowFormRepository;
use App\Repositories\Interfaces\IAccountRepository;
use App\Repositories\Interfaces\ICriteriaFormRepository;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\IEmployeeRepository;
use App\Repositories\Interfaces\IEvaluationAnswerDetailRepository;
use App\Repositories\Interfaces\IEvaluationAnswerRepository;
use App\Repositories\Interfaces\IEvaluationCriteriaRepository;
use App\Repositories\Interfaces\IEvaluationCycleRepository;
use App\Repositories\Interfaces\IEvaluationQuestionRepository;
use App\Repositories\Interfaces\IHFormItemRepository;
use App\Repositories\Interfaces\IHowFormItemRepository;
use App\Repositories\Interfaces\IHowFormRepository;
use App\Repositories\Interfaces\IOperationRepository;
use App\Repositories\Interfaces\IPersonalDevelopmentFormRepository;
use App\Repositories\Interfaces\IPlantRepository;
use App\Repositories\Interfaces\IPositionRepository;
use App\Repositories\Interfaces\ITotalCriteriaScoreRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IWformItemRepository;
use App\Repositories\Interfaces\IWhatFormRepository;
use App\Repositories\OperationRepository;
use App\Repositories\PersonalDevelopmentFormRepository;
use App\Repositories\PlantRepository;
use App\Repositories\PositionRepository;
use App\Repositories\TotalCriteriaScoreRepository;
use App\Repositories\UserRepository;
use App\Repositories\WformItemRepository;
use App\Repositories\WhatFormRepository;
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
        $this->app->bind(IEvaluationQuestionRepository::class, EvaluationQuestionRepository::class);
        $this->app->bind(IEvaluationAnswerRepository::class, EvaluationAnswerRepository::class);
        $this->app->bind(IEvaluationAnswerDetailRepository::class, EvaluationAnswerDetailRepository::class);
        $this->app->bind(ITotalCriteriaScoreRepository::class, TotalCriteriaScoreRepository::class);
        $this->app->bind(IHowFormRepository::class, HowFormRepository::class);
        $this->app->bind(IHFormItemRepository::class, HFormItemRepository::class);
        $this->app->bind(IWhatFormRepository::class, WhatFormRepository::class);
        $this->app->bind(IPersonalDevelopmentFormRepository::class, PersonalDevelopmentFormRepository::class);
        $this->app->bind(IWformItemRepository::class, WformItemRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
