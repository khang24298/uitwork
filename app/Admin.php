<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admins';

    protected $fillable = [
        'username', 'email','departmentID','name',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
