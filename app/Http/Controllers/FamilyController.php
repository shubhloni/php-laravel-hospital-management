<?php

namespace App\Http\Controllers;
use App\Family;
use App\Patient;

use Illuminate\Http\Request;

class FamilyController extends Controller
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

  private function checkUserRole()
  {
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }
  }
  /**
   * Display a Listing of all Resources
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $fams = Family::all();
    $pats = Patient::all();
    return view('family.index')->with('fams',$fams)->with('pats',$pats);
  }

  public function create()
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    return view('family.create');
  }

  public function addPatient($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $fam = Family::find($id);
    return view('family.addPatient')->with('fam',$fam);
  }

  public function store(Request $request)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'name'  => 'required',
      'mobile' => 'required|numeric|digits:10',
      'address' => 'required|max:20'
    ]);

    $fam = new Family;
    $fam->name = $request->input('name');
    $fam->mobile = $request->input('mobile');
    $fam->address = $request->input('address');
    $fam->referance = $request->input('referance');
    $fam->amount_pending = $request->input('amount_pending');
    $fam->save();

    return redirect('/family')->with('success','Family Added');
  }

  public function edit($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $fam= Family::find($id);
    return view('family.edit')->with('fam',$fam);
  }

  public function update(Request $request,$id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'name'  => 'required',
      'mobile' => 'required|numeric|digits:10',
      'address' => 'required|max:20'
    ]);

    $fam = Family::find($id);
    $fam->name = $request->input('name');
    $fam->mobile = $request->input('mobile');
    $fam->address = $request->input('address');
    $fam->referance = $request->input('referance');
    $fam->amount_pending = $request->input('amount_pending');
    $fam->save();

    return redirect('/family')->with('success','Family Updated!!');
  }

  public function show($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $fam = Family::find($id);
    // return response()->json($fam,200);
    return view('family.show')->with('pats', $fam->patients)->with('fam',$fam);
  }

  public function destroy($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $fam = Family::find($id);
    if (auth()->user()->user_role !== '1') {
      return redirect('/family')->with('error','Unauthorized Access!!');
    }
    $fam->delete();
    return redirect('/family')->with('success','Family Removed!!');
  }

}
