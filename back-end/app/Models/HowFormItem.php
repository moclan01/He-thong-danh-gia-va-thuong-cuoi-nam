<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HowFormItem extends Model
{
    protected $primaryKey = 'how_form_items_id';

    protected $fillable = [
        'how_form_id',
        'hform_item_id',
    ];

    public function howForm()
    {
        return $this->belongsTo(HowForm::class, 'how_form_id', 'how_form_id');
    }

    public function hformItem()
    {
        return $this->belongsTo(HformItem::class, 'hform_item_id', 'hform_item_id');
    }
}
