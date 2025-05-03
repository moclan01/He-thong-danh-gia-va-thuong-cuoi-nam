<?php
namespace App\Repositories\Interfaces;

interface IAccountRepository extends IRepositories{
    public function getByCode($code);
}