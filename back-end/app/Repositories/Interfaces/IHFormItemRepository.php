<?php
namespace App\Repositories\Interfaces;

interface IHFormItemRepository extends IRepositories{
    public function getByHowForm($how_form_id);
}