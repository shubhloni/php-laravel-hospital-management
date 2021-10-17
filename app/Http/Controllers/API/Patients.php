<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Patient;

class Patients extends Controller
{
  public function patients(){
      return response()->json(Patient::get(), 200);
    }
}
