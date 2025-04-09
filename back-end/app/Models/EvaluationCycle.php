<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCycle extends Model
{
    protected $primaryKey = 'cycles_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'cycles_id',
        'department_id',
        'start_date',
        'end_date',
        'status',
        'created_at',
        'updated_at',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function criteriaForms()
    {
        return $this->hasMany(CriteriaForm::class, 'cycles_id', 'cycles_id');
    }
}
