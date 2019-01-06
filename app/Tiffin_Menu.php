<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tiffin_Menu extends Model
{
   protected $table = 'tiffin_menus';

   public function tiffin()
   {
      return $this->belongsTo(Tiffin::class);
   }
}
