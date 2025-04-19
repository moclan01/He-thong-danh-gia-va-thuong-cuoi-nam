<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    
    use Notifiable, HasRoles, HasApiTokens;

    protected $primaryKey = 'id';
    public $incrementing = true; 
    protected $keyType = 'int';  

    protected $fillable = ['username', 'code', 'password', 'status', 'role'];
    
    public $timestamps = false;
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'code', 'code');
    }
}
