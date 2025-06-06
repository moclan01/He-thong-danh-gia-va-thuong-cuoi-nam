<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HformItem extends Model
{
    protected $primaryKey = 'hform_item_id';

    protected $fillable = [
        'total_criteria_score_id',
        'name',
        'weighting',
        'threshold',
        'target',
        'stretch',
        'comments',
        'FY_target',
        'actual',
        'score',
    ];

    public function totalCriteriaScore()
    {
        return $this->belongsTo(TotalCriteriaScore::class, 'total_criteria_score_id', 'total_criteria_score_id');
    }

    public function howFormItems()
    {
        return $this->hasMany(HowFormItem::class, 'hform_item_id', 'hform_item_id');
    }
}
