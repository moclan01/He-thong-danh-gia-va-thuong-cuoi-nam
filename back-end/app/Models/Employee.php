<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'code';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'plant_id',
        'department_id',
        'fullname',
        'position',
        'start_date',
        'type',
        'eligible',
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'plant_id', 'plant_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'employee_code', 'code');
    }

    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manage_code', 'code');
    }
}
