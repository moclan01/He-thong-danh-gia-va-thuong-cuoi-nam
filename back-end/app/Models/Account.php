<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['code', 'username', 'password', 'role', 'status'];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'code', 'code');
    }
}
