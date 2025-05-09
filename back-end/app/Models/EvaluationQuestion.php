<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    protected $primaryKey = 'evaluation_question_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['evaluation_criteria_id', 'question_name', 'max_score'];

    protected $casts = [
        'evaluation_criteria_id' => 'integer',
    ];

    public function evaluationCriteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaluation_criteria_id', 'evaluation_criteria_id');
    }

    public function evaluationAnswerDetails()
    {
        return $this->hasMany(EvaluationAnswerDetail::class, 'evaluation_question_id', 'evaluation_question_id');
    }
}
