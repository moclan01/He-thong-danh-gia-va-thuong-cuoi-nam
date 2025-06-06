<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HformItem extends Model
{
    protected $primaryKey = 'hform_item_id';

    protected $fillable = [
        'total_criteria_score_id',
        'how_form_id',
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
        'n'
    ];

     protected $casts = [
        'total_criteria_score_id' => 'integer',
        'how_form_id' => 'integer',
        'weighting' => 'float',
        'threshold' => 'float',
        'target' => 'float',
        'stretch' => 'float',
        'FY_target' => 'float',
        'actual' => 'float',
        'score' => 'float',
        'm' => 'float',
        'n' => 'float',
    ];

    public function totalCriteriaScore()
    {
        return $this->belongsTo(TotalCriteriaScore::class, 'total_criteria_score_id', 'total_criteria_score_id');
    }

    public function howForm()
    {
        return $this->belongsTo(HowForm::class, 'how_form_id', 'how_form_id');
    }
}
