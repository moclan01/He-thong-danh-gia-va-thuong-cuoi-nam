<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria';
    protected $primaryKey = 'criteria_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'criteria_id',
        'department_id',
        'criteria_name',
        'description',
        'weight',
        'status',
    ];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
