<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'department_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'department_id',
        'manage_code', 
        'department_name',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'department_id');
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manage_code', 'code');
    }
}
