<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   public function users($column)
   {
       return $this->belongsTo(User::class,$column);
   }
}
