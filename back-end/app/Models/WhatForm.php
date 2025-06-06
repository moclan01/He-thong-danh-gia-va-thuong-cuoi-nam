<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatForm extends Model
{
    protected $primaryKey = 'what_form_id';
    protected $fillable = [
        'evaluation_cycle_id',
        'what_form_name',
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
        return $this->hasMany(WformItem::class, 'what_form_id','what_form_id');
    }
}
