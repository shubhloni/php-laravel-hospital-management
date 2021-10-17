@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add User</div>
                <div class="card-body">

                {!! Form::open(['action'=>'UserController@store','method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                <div class="form-group">
                  {{Form::label('name','Name*')}}
                  {{Form::text('name','',['class'=>'form-control','placeholder'=>'Name', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::label('email','Email*')}}
                  {{Form::text('email','',['class'=>'form-control','placeholder'=>'Email', 'required'])}}
                </div>
                <div class="form-group">
                  {{Form::label('password','Password*')}}
                  {{Form::password('password',array('id' => 'password', "class" => "form-control", "autocomplete" => "off", 'required'))}}
                </div>
                <div class="form-group">
                  {{Form::label('confirm_password','Confirm Password*')}}
                  {{Form::password('confirm_password',array('id' => 'confirm_password', "class" => "form-control", "autocomplete" => "off", 'required'))}}
                </div>
                <div class="form-group" style="width:25%">
                  {{Form::label('user_role','User Role*')}}
                  <select id="user_role" name="user_role" class="form-control" >
                    <option value="2"> Non-Admin </option>
                    <option value="1"> Admin </option>
                  </select>
                </div>
                {!! Form::submit('Register',['class'=>'btn btn-primary']) !!}
                {!! Form::reset('Reset',['class'=>'btn btn-primary']) !!}
                <a href="/TestProject/public/user" class="btn btn-primary">Cancel</a>
                {!! Form::close() !!}
              </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
