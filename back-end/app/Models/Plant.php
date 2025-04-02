<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    protected $primaryKey = 'plant_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'plant_id',
        'plant_name',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'plant_id', 'plant_id');
    }
}
