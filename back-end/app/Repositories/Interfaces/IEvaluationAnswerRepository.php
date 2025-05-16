<?php
namespace App\Repositories\Interfaces;

interface IEvaluationAnswerRepository extends IRepositories{
    public function getByCode(string $code);
}