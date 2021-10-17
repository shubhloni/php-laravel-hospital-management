@extends('layouts.app')

@section('content')

<h3>{{$pat->name}} - Add Patient Record</h3>
{!! Form::open(['action'=>'PatientRecordController@store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
  {{Form::label('record_title','Record Title*')}}
  {{Form::text('record_title','',['class'=>'form-control','placeholder'=>'Record Title'],'required')}}
</div>
<div class="form-group">
  {{Form::label('details','Details')}}
  {{Form::textarea('details','',['class'=>'form-control','placeholder'=>'Details of Admission'])}}
</div>

<div class="form-group row" style="padding:10px">
{{-- <div class="form-group"> --}}
  <div style="width:15%" class="col-md-2">
    {{Form::label('admit_date','Admit Date*')}}
    {{Form::date('admit_date','',['class'=>'form-control','placeholder'=>'Admit Date'],'required')}}
  </div>

  <div style="width:15%" class="col-md-2">
    {{Form::label('treat_amount','Treatment Amount')}}
    {{Form::text('treatment_amount','',['class'=>'form-control','placeholder'=>'Amount in Rs'],'required')}}
  </div>

  <div class="col-md-2">
    @if($pat !== null)
      {{Form::label('payment_status','Payment Status*')}}
      <select id="payment_status" name="payment_status" class="form-control" >
        <option value="1"> Open </option>
        <option value="2"> Close </option>
      </select>
    @endif
  </div>
{{-- </div> --}}
</div>
<br>

{!! Form::hidden('patient_id', $pat->id ) !!}

{!! Form::submit('Add',['class'=>'btn btn-primary']) !!}
{!! Form::reset('Reset',['class'=>'btn btn-primary']) !!}
<a href="/TestProject/public/patients/{{$pat->id}}" class="btn btn-primary">Cancel</a>
{!! Form::close() !!}

@endsection
