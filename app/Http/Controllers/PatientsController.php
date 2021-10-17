<?php

namespace App\Http\Controllers;
use App\Patient;
use App\PatientRecord;
use App\Family;

use Illuminate\Http\Request;

class PatientsController extends Controller
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
      redirect('/home')->with('error','Unauthorized Access!!');
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

    $pats = Patient::all();
    $fams = Family::all();
    return view('patients.index')->with('pats',$pats)->with('fams',$fams);
  }

  public function create()
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }
    $fams = Family::all();
    return view('patients.create')->with('fams',$fams);
  }

  public function addPat()
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }
    return view('family.addPat');
    // ->with('fam',$fam);
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
      'family' => 'required',
      'mobile' => 'nullable|numeric|digits:10',
      'address' => 'max:20'
    ]);

    $pat = new Patient;
    $pat->name = $request->input('name');
    $pat->mobile = $request->input('mobile');
    $pat->address = $request->input('address');
    $family = $request->input('family');
    $family_id = explode(" ", $family);
    $pat->family_id = $family_id[0];
    $pat->save();

    return redirect('/patients')->with('success','Patient Added');
  }

  public function edit($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    $fam_id = $pat->family_id;
    $fam = Family::find($fam_id);
    return view('patients.edit')->with('pat',$pat)->with('fam',$fam);
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
      'family' => 'required',
      'mobile' => 'nullable|numeric|digits:10',
      'address' => 'max:20'
    ]);

    $pat = Patient::find($id);
    $pat->name = $request->input('name');
    $pat->mobile = $request->input('mobile');
    $pat->address = $request->input('address');
    $family = $request->input('family');
    $family_id = explode(" ", $family);
    $pat->family_id = $family_id[0];
    $pat->save();

    return redirect('/patients')->with('success','Patient Updated!!');
  }

  public function updateStatus($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    $pat->amount_pending = '0';
    $pat->payment_status = '2';
    $pat->close_date = date('Y-m-d');
    $pat->updated_by = auth()->user()->name;
    $pat->save();

    PatientRecord::where('patient_id',$pat->id)->update(['payment_status'=>'2','updated_by'=>auth()->user()->name,'close_date'=>date('Y-m-d')]);

    // $fam = Family::find($pat->family_id);
    return redirect('family/'.$pat->family_id)->with('success','Patients Payment Status Closed!!');
    // ->with('pats', $fam->patients)->with('fam',$fam);

    // return redirect('family'.$pat->family_id)->with('success','Patients Payment Status Closed!!');
  }

  public function show($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    // return response()->json($fam,200); ->where('payment_status','1')
    return view('patient_records.index')->with('pat_records', $pat->patient_records()->orderBy('admit_date', 'desc')->get())->with('pat',$pat);
  }

  public function destroy($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    if (auth()->user()->user_role != '1') {
      return redirect('/patients')->with('error','Unauthorized Access!!');
    }
    $pat->delete();
    return redirect('/patients')->with('success','Patient Removed!!');
  }

}
