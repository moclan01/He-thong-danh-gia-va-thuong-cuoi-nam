<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalDevelopmentForm extends Model
{
    protected $primaryKey = 'personal_development_form_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'evaluation_cycle_id',
        'form_name',
        'total_weighting',
        'total_score',
        'status',
    ];

    public function evaluationCycle()
    {
        return $this->belongsTo(EvaluationCycle::class, 'evaluation_cycle_id', 'evaluation_cycle_id');
    }

    public function items()
    {
        return $this->hasMany(WformItem::class, 'personal_development_form_id', 'personal_development_form_id');
    }
}
