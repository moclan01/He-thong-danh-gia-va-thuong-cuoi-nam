<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    protected $primaryKey = 'criteria_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'criteria_id',
        'criteria_name',
        'description',
        'weight',
        'status',
        'created_at',
        'updated_at',
    ];

    public function criteriaForms()
    {
        return $this->hasMany(CriteriaForm::class, 'criteria_id', 'criteria_id');
    }
}
