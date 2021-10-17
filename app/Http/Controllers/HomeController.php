<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Family;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fam_count = DB::table('families')->count();
        $pat_count = DB::table('patients')->count();
        $pat_admit = DB::table('patients')->where('payment_status','=','1')->count();
        $amount_pending = DB::table('patients')->sum('amount_pending');
        return view('home')->with('fam_count',$fam_count)->with('pat_count',$pat_count)
        ->with('pat_admit',$pat_admit)->with('amount_pending',$amount_pending);
    }
}
