@extends('layouts.app')

@section('content')

<h1>Add Patient</h1>
{!! Form::open(['action'=>'PatientsController@store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
<div class="form-group">
  {{Form::label('name','Name*')}}
  {{Form::text('name','',['class'=>'form-control','placeholder'=>'Name'],'required')}}
</div>
<div class="form-group">
  {{Form::label('mobile','Mobile')}}
  {{Form::text('mobile','',['class'=>'form-control','placeholder'=>'Mobile'],'required')}}
</div>
<div class="form-group">
  {{Form::label('address','Address')}}
  {{Form::text('address','',['class'=>'form-control','placeholder'=>'Address'],'required')}}
</div>
<div class="form-group">
{{-- Check if Families loaded --}}
  @if(!$fam == null)
    <?php $select_data = array(); ?>
    <select id="family" name="family" class="form-control" >
    {{-- @foreach ($fams as $fam) --}}

      {{-- $select_data[] = $fam->id.' '.$fam->name;  --}}
      <option value="{{ $fam->id.' '.$fam->name }}"> {{$fam->id.' '.$fam->name}}</option>
    {{-- @endforeach --}}
  </select>
  @endif
  {{-- <h4>{{ $data }}</h4> --}}

  {{-- {{Form::label('family','Family*')}}
  {!! Form::select('family', $select_data, null, array('class' => 'form-control')) !!} --}}

</div>
{!! Form::submit('Add',['class'=>'btn btn-primary']) !!}
{!! Form::reset('Reset',['class'=>'btn btn-primary']) !!}
<a href="/TestProject/public/family/{{$fam->id}}" class="btn btn-primary">Cancel</a>
{!! Form::close() !!}

@endsection
