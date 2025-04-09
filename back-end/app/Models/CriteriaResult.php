<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaResult extends Model
{
    protected $primaryKey = 'criteria_result_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'criteria_result_id',
        'employee_code',
        'criteria_form_id',
        'score',
        'score_max',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_code', 'code');
    }

    public function criteriaForm()
    {
        return $this->belongsTo(CriteriaForm::class, 'criteria_form_id', 'criteria_form_id');
    }
}
