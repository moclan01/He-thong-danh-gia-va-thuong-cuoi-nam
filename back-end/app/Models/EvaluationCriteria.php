<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    protected $primaryKey = 'evaluation_criteria_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['criteria_form_id', 'criteria_name'];

    public function criteriaForm()
    {
        return $this->belongsTo(CriteriaForm::class, 'criteria_form_id', 'criteria_form_id');
    }

    public function evaluationQuestions()
    {
        return $this->hasMany(EvaluationQuestion::class, 'evaluation_criteria_id', 'evaluation_criteria_id');
    }
}
