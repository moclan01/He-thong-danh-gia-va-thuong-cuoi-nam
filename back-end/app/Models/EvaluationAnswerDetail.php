<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswerDetail extends Model
{
    protected $primaryKey = 'evaluation_answer_detail_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['evaluation_question_id', 'evaluation_answer_id', 'score'];

    protected $casts = [
        'evaluation_question_id' => 'integer',
        'evaluation_answer_id' => 'integer',
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
