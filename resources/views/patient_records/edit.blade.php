@extends('layouts.app')

@section('content')

<h3>{{$pat->name}} - Update Record</h3>
{!! Form::open(['action'=>['PatientRecordController@update',$pat_record->id],'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
  {{Form::label('record_title','Record Title*')}}
  {{Form::text('record_title',$pat_record->record_title,['class'=>'form-control','placeholder'=>'Record Title','readonly'])}}
</div>
<div class="form-group">
  {{Form::label('details','Details')}}
  {{Form::textarea('details',$pat_record->details,['class'=>'form-control','placeholder'=>'Details of Admission'])}}
</div>

<div class="form-group row" style="padding:10px">
{{-- <div class="form-group"> --}}
  <div style="width:15%" class="col-md-2">
    {{Form::label('admit_date','Admit Date*')}}
    {{Form::date('admit_date',$pat_record->admit_date,['class'=>'form-control','placeholder'=>'Admit Date','readonly'])}}
  </div>

  <div style="width:15%" class="col-md-2">
    {{Form::label('treat_amount','Treatment Amount')}}
    {{Form::text('treatment_amount',$pat_record->treat_amount,['class'=>'form-control','placeholder'=>'Amount in Rs'])}}
  </div>

  <div class="col-md-2">
    @php
      if ($pat_record->payment_status == '1'){
        $status = 'Open';
      }
      else{
        $status = 'Close';
      }
    @endphp
      {{Form::label('payment_status','Payment Status*')}}
      {{Form::text('payment_status', $status ,['class'=>'form-control','placeholder'=>'Payment Status','readonly'])}}
      {{-- <select id="payment_status" name="payment_status" class="form-control" >
        <option value="1"> Open </option>
        <option value="2"> Close </option>
      </select> --}}
  </div>
{{-- </div> --}}
</div>
<p>Please mention changes made with reason in details area..</p>
{!! Form::hidden('patient_id', $pat->id ) !!}
{!! Form::hidden('_method','PUT') !!}
{!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
{{-- {!! Form::reset('Reset',['class'=>'btn btn-primary']) !!} --}}
<a href="/TestProject/public/patients/{{$pat->id}}" class="btn btn-primary">Cancel</a>
{!! Form::close() !!}

@endsection
