<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $primaryKey = 'operation_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['department_id', 'operation_name'];

    protected $casts = [
        'department_id' => 'integer',
    ];
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class, 'operation_id', 'operation_id');
    }
}
