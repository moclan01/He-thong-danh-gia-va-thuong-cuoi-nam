<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCycle extends Model
{
    protected $primaryKey = 'evaluation_cycle_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['department_id', 'cycle_name', 'start_date', 'end_date', 'status'];

    protected $casts = [
        'department_id' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function criteriaForms()
    {
        return $this->hasMany(CriteriaForm::class, 'evaluation_cycle_id', 'evaluation_cycle_id');
    }
}
