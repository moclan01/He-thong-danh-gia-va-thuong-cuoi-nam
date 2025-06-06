<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WformItem extends Model
{
    protected $primaryKey = 'wform_item_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'what_form_id',
        'personal_development_form_id',
        'name',
        'weighting',
        'threshold',
        'target',
        'stretch',
        'comments',
        'FY_target',
        'actual',
        'score',
        'm',
        'n',
    ];

    public function whatForm()
    {
        return $this->belongsTo(WhatForm::class, 'what_form_id', 'what_form_id');
    }

    public function personalDevelopmentForm()
    {
        return $this->belongsTo(PersonalDevelopmentForm::class, 'personal_development_form_id', 'personal_development_form_id');
    }
}
