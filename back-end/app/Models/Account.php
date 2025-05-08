<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Account extends Model
{
    use HasApiTokens;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $fillable = ['code', 'username', 'password', 'role', 'status', 'token'];

    protected $hidden = ['password'];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'code', 'code');
    }
}
