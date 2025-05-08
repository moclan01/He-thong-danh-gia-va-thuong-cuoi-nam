<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $primaryKey = 'position_id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = ['operation_id', 'position_name'];

    protected $casts = [
        'operation_id' => 'integer',
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'operation_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id', 'position_id');
    }
}
