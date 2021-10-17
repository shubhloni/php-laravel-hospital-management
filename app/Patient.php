<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{

  public function family(){
    return $this->belongsTo('App\Family');
  }

  public function patient_records(){
    return $this->hasMany('App\PatientRecord');
  }

}
