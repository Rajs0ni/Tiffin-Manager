<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiffin extends Model
{
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function menus()
    {
        return $this->hasMany(Tiffin_Menu::class,'tiffin_id');
    }
    
}
