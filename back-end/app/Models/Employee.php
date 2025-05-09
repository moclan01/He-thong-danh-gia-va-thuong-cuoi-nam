<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'code';
    public $incrementing = false; 
    protected $keyType = 'string'; 
    protected $fillable = [
        'code', 'plant_id', 'department_id', 'position_id', 'code_r',
        'fullname', 'division', 'basic', 'grade', 'stafftype', 'start_date', 'type'
    ];

    protected $casts = [
        'plant_id' => 'integer',
        'department_id' => 'integer',
        'position_id' => 'integer',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'code', 'code');
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'plant_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'code_r', 'code');
    }
    
    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manage_code', 'code');
    }

    public function evaluationAnswers()
    {
        return $this->hasMany(EvaluationAnswer::class, 'code', 'code');
    }
}
