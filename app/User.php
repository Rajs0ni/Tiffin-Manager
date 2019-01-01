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

    public function scopeTiffin($query, $tiffin_id)
    {
        return Tiffin::findOrFail($tiffin_id);  
    }
}
