<?php

namespace App\Http\Controllers;
use App\Patient;
use App\PatientRecord;
use App\Http\Controllers\PatientsController;

use Illuminate\Http\Request;
use DB;

class PatientRecordController extends Controller
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
  public function index($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    return view('patient_records.index')->with('pat_records', $pat->patient_records()->orderBy('admit_date', 'desc')->get())->with('pat',$pat);
  }

  public function create($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat = Patient::find($id);
    return view('patient_records.create')->with('pat',$pat);
  }

  public function store(Request $request)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'record_title'  => 'required|max:20',
      'admit_date' => 'required',
      'treatment_amount' => 'required|numeric',
    ]);

    $pat_record = new PatientRecord;
    $pat = Patient::find($request->input('patient_id'));

    $pat_record->record_title = $request->input('record_title');
    $pat_record->admit_date = $request->input('admit_date');
    $pat_record->admit_date = date('Y-m-d', strtotime($pat_record->admit_date));
    $pat_record->treat_amount = $request->input('treatment_amount');

    $pat_record->details = $request->input('details');
    if ($pat_record->details == '') {
      $pat_record->details = '-';
    }
    $pat_record->payment_status = $request->input('payment_status');

    if ($pat_record->payment_status == '2') {
      $pat_record->close_date = date('Y-m-d');
    }
    else {
      //Get current pending amount for patient and add new amount
      $pat->amount_pending = $pat->amount_pending + $pat_record->treat_amount;
      //Update payment_status
      $pat->payment_status = '1';
    }

    $pat_record->created_by = auth()->user()->name;
    $pat_record->patient_id = $request->input('patient_id');

    $pat_record->save();
    $pat->save();

    return redirect('patients/'.$pat_record->patient_id)->with('success','Patient Record Added!!');

    //return \App::call('App\Http\Controllers\PatientsController@show('.$pat_record->patient_id.')');

    //return \Redirect::route('/TestProject/public/patients/'.$pat_record->patient_id);

    //app('App\Http\Controllers\PatientsController')->show($pat_record->patient_id);

    //return view('patient_records.index')->with('pat_records', $pat->patient_records()->orderBy('admit_date', 'desc')->get())->with('pat',$pat);
  }

  public function edit($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat_record = PatientRecord::find($id);
    $pat_id = $pat_record->patient_id;
    $pat = Patient::find($pat_id);
    return view('patient_records.edit')->with('pat_record',$pat_record)->with('pat',$pat);
  }

  public function update(Request $request, $id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $this->validate($request,[
      'treatment_amount' => 'required|numeric',
      'details'          => 'required'
    ]);

    $pat_record = PatientRecord::find($id);
    $pat = Patient::find($pat_record->patient_id);
    // $pat_record->record_title = $request->input('record_title');
    // $pat_record->admit_date = $request->input('admit_date');
    // $pat_record->admit_date = date('Y-m-d', strtotime($pat_record->admit_date));
    $old_amount = $pat_record->treat_amount;
    $pat_record->treat_amount = $request->input('treatment_amount');
    $pat_record->details = $request->input('details');

    //Change in Pending Amount of Patient table
    $pat->amount_pending = $pat->amount_pending - $old_amount;
    $pat->amount_pending = $pat->amount_pending + $pat_record->treat_amount;

    // $pat_record->payment_status = $request->input('payment_status');

    // if ($pat_record->payment_status == '2') {
    //   $pat_record->close_date = date('Y-m-d');
    // }

    $pat_record->updated_by = auth()->user()->name;
    // $pat_record->patient_id = $request->input('patient_id');

    $pat_record->save();
    $pat->save();

    return redirect('patients/'.$pat_record->patient_id)->with('success','Patient Record Updated!!');

  }

  public function updateStatus($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat_record = PatientRecord::find($id);
    $pat = Patient::find($pat_record->patient_id);

    $pat_record->payment_status = '2';
    $pat_record->close_date = date('Y-m-d');
    $pat_record->updated_by = auth()->user()->name;
    $pat_record->save();

    $pat->amount_pending = $pat->amount_pending - $pat_record->treat_amount;

    $pat_records = DB::table('patient_records')->where(['patient_id'=>$pat_record->patient_id,'payment_status'=>'1'])->count();
    if ($pat_records == 0) {
      $pat->payment_status = '2';
    }
    $pat->save();

    return redirect('patients/'.$pat_record->patient_id)->with('success','Record Status Closed!!');
  }

  public function destroy($id)
  {
    // $this->checkUserRole();
    if (auth()->user()->user_role == '3')
    {
      return redirect('/home')->with('error','Unauthorized Access!!');
    }

    $pat_record = PatientRecord::find($id);
    if (auth()->user()->user_role != '1') {
      return redirect('patients/'.$pat_record->patient_id)->with('error','Unauthorized Access!!');
    }
    $pat_record->delete();
    return redirect('patients/'.$pat_record->patient_id)->with('success','Patient Record Removed!!');

  }

}
