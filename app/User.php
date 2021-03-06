<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    // protected $primaryKey = 'mobile';
    protected $hidden = [
        //  'remember_token',
        'is_provider'
    ];

    protected $fillable = [
        'mobile', 'name','location'
    ];

    public function tiffins()
    {
        return $this->hasMany(Tiffin::class, 'provider_id');
    }

    public function orders($columnName)
    {
        return $this->hasMany(Order::class, $columnName)         
                    ->orderBy('status','asc')
                    ->orderBy('created_at','desc');
                    
    }
}
