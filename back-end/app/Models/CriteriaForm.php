<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaForm extends Model
{
    protected $primaryKey = 'criteria_form_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'criteria_form_id',
        'cycles_id',
        'criteria_id',
    ];

    public function evaluationCycle()
    {
        return $this->belongsTo(EvaluationCycle::class, 'cycles_id', 'cycles_id');
    }

    public function evaluationCriteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteria_id', 'criteria_id');
    }

    public function criteriaResults()
    {
        return $this->hasMany(CriteriaResult::class, 'criteria_form_id', 'criteria_form_id');
    }
}
