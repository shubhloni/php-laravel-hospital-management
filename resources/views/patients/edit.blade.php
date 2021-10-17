@extends('layouts.app')

@section('content')

<h1>{{$pat->name}} - Edit Patient</h1>
{!! Form::open(['action'=>['PatientsController@update',$pat->id],'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
  {{Form::label('name','Name*')}}
  {{Form::text('name',$pat->name,['class'=>'form-control','placeholder'=>'Name'],'required')}}
</div>
<div class="form-group">
  {{Form::label('mobile','Mobile')}}
  {{Form::text('mobile',$pat->mobile,['class'=>'form-control','placeholder'=>'Mobile'],'required')}}
</div>
<div class="form-group">
  {{Form::label('address','Address')}}
  {{Form::text('address',$pat->address,['class'=>'form-control','placeholder'=>'Address'],'required')}}
</div>
<div class="form-group">
{{-- Check if Families loaded --}}
  @if(!$fam == null)
    {{Form::label('family','Family*')}}
    <select id="family" name="family" class="form-control" >
      <option value="{{ $fam->id.' '.$fam->name }}"> {{$fam->id.' '.$fam->name}}</option>
    </select>
  @endif

</div>
{!! Form::hidden('_method','PUT') !!}
{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}
{{-- {!! Form::reset('Reset',['class'=>'btn btn-primary']) !!} --}}
<a href="/TestProject/public/family/{{$fam->id}}" class="btn btn-primary">Cancel</a>
{!! Form::close() !!}

@endsection
