<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HowForm extends Model
{

    protected $primaryKey = 'how_form_id';

    protected $fillable = [
        'how_form_name',
        'total_weighting',
        'total_score',
        'status',
    ];

    public function howFormItems()
    {
        return $this->hasMany(HowFormItem::class, 'how_form_id', 'how_form_id');
    }
}
