<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswer extends Model
{
    protected $primaryKey = 'evaluation_answer_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['code', 'criteria_form_id', 'total_score'];

    protected $casts = [
        'criteria_form_id' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'code', 'code');
    }

    public function criteriaForm()
    {
        return $this->belongsTo(CriteriaForm::class, 'criteria_form_id', 'criteria_form_id');
    }

    public function evaluationAnswerDetails()
    {
        return $this->hasMany(EvaluationAnswerDetail::class, 'evaluation_answer_id', 'evaluation_answer_id');
    }
}
