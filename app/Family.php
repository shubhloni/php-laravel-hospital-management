<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
  public function patients(){
    return $this->hasMany('App\Patient');
  }
}
