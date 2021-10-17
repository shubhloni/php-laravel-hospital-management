@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add User</div>
                <div class="card-body">

                {!! Form::open(['action'=>['UserController@update',$user->id],'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                <div class="form-group">
                  {{Form::label('name','Name*')}}
                  {{Form::text('name',$user->name,['class'=>'form-control','placeholder'=>'Name', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::label('email','Email*')}}
                  {{Form::text('email',$user->email,['class'=>'form-control','placeholder'=>'Email' ,'readonly'])}}
                </div>
                <div class="form-group">
                  {{Form::label('mobile','Mobile')}}
                  {{Form::text('mobile',$user->mobile,['class'=>'form-control','placeholder'=>'Mobile'])}}
                </div>
                <div class="form-group">
                  {{Form::label('Address','Address')}}
                  {{Form::text('address',$user->address,['class'=>'form-control','placeholder'=>'Address'])}}
                </div>
                <div class="form-group" style="width:25%">
                  {{Form::label('user_role','User Role*')}}
                  <select id="user_role" name="user_role" class="form-control" >
                    <option value="2"> Non-Admin </option>
                    <option value="3"> Block </option>
                    <option value="1"> Admin </option>
                  </select>
                </div>
                {!! Form::hidden('_method','PUT') !!}
                {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
                {{-- {!! Form::reset('Reset',['class'=>'btn btn-primary']) !!} --}}
                <a href="/TestProject/public/user" class="btn btn-primary">Cancel</a>
                {!! Form::close() !!}
              </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
