<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalCriteriaScore extends Model
{

    protected $primaryKey = 'total_criteria_score_id';

    protected $fillable = [
        'evaluation_answer_id',
        'evaluation_criteria_id',
        'total_score_manager',
    ];

    public function evaluationAnswer()
    {
        return $this->belongsTo(EvaluationAnswer::class, 'evaluation_answer_id', 'evaluation_answer_id');
    }

    public function evaluationCriteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaluation_criteria_id', 'evaluation_criteria_id');
    }

    public function hformItems()
    {
        return $this->hasMany(HformItem::class, 'total_criteria_score_id', 'total_criteria_score_id');
    }
}
