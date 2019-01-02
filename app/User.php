<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = [
         'remember_token',
    ];

    public function tiffins()
    {
        return $this->hasMany(Tiffin::class, 'provider_id');
    }

}
