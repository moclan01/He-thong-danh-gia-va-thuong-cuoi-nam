<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswerDetail extends Model
{
    protected $primaryKey = 'evaluation_answer_detail_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = [
        'evaluation_question_id',
        'evaluation_answer_id',
        'score',
        'employee_score',
        'manager_score',
        'supervisor_score',
        'director_score',
        'employee_comment',
        'supervisor_comment',
    ];

    protected $casts = [
        'evaluation_question_id' => 'integer',
        'evaluation_answer_id' => 'integer',
        'employee_score' => 'float',
        'manager_score' => 'float',
        'supervisor_score' => 'float',
        'director_score' => 'float',
    ];

    public function evaluationQuestion()
    {
        return $this->belongsTo(EvaluationQuestion::class, 'evaluation_question_id', 'evaluation_question_id');
    }

    public function evaluationAnswer()
    {
        return $this->belongsTo(EvaluationAnswer::class, 'evaluation_answer_id', 'evaluation_answer_id');
    }


}
