@extends('layouts.app')

@section('content')

<h1>{{$fam->name}} - Edit Family</h1>
{!! Form::open(['action'=>['FamilyController@update',$fam->id],'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
  {{Form::label('name','Name*')}}
  {{Form::text('name',$fam->name,['class'=>'form-control','placeholder'=>'Name'],'required')}}
</div>
<div class="form-group">
  {{Form::label('mobile','Mobile*')}}
  {{Form::text('mobile',$fam->mobile,['class'=>'form-control','placeholder'=>'Mobile'],'required')}}
</div>
<div class="form-group">
  {{Form::label('address','Address*')}}
  {{Form::text('address',$fam->address,['class'=>'form-control','placeholder'=>'Address'],'required')}}
</div>
<div class="form-group">
  {{Form::label('referance','Referance')}}
  {{Form::text('referance',$fam->referance,['class'=>'form-control','placeholder'=>'Referance'],'required')}}
</div>
{{-- <div class="form-group">
  {{Form::label('amount_pending','Amount Pending')}}
  {{Form::text('amount_pending',$fam->amount_pending,['class'=>'form-control','placeholder'=>'Amount Pending'],'required')}}
</div> --}}
{!! Form::hidden('_method','PUT') !!}
{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
{{-- {!! Form::reset('Reset',['class'=>'btn btn-primary']) !!} --}}
<a href="/TestProject/public/family" class="btn btn-primary">Cancel</a>
{!! Form::close() !!}

@endsection
