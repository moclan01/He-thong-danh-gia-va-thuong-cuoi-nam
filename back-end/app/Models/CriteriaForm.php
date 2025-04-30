<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaForm extends Model
{
    protected $primaryKey = 'criteria_form_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['evaluation_cycle_id', 'criteria_form_name'];

    public function evaluationCycle()
    {
        return $this->belongsTo(EvaluationCycle::class, 'evaluation_cycle_id', 'evaluation_cycle_id');
    }

    public function evaluationCriteria()
    {
        return $this->hasMany(EvaluationCriteria::class, 'criteria_form_id', 'criteria_form_id');
    }

    public function evaluationAnswers()
    {
        return $this->hasMany(EvaluationAnswer::class, 'criteria_form_id', 'criteria_form_id');
    }
}
