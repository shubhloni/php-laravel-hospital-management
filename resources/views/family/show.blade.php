@extends('layouts.app')

<script>
function myFunction() {

  if(!confirm("Do you really want to Delete?")) {
    return false;
  }
  this.form.submit();
}
</script>

@php
  $amount_pending = 0;
@endphp

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center"> --}}
        {{-- <div class="col-md-8"> --}}
            <div class="card" style="padding:10px">
                <div class="card-header"><h3><b>{{$fam->name}}</b> - Family Details</h3></div>

                {{-- <div class="card-body"> --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="padding:10px">

                      <div class="col-md-2">
                        <a href="/TestProject/public/family" class="btn">Back</a>
                      </div>

                      <div class="col-md-2">
                        <a href="/TestProject/public/family/addPatient/{{$fam->id}}" class="btn btn-primary">Add Patient</a>
                      </div>

                      @if (count($pats)==0 && auth()->user()->user_role == '1')
                        <div class="col-md-2">
                          {!! Form::open(['action'=>['FamilyController@destroy',$fam->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                          {{Form::hidden('_method','DELETE')}}
                          {{Form::submit('Delete Family',['class'=>'btn btn-danger','onclick'=>'return myFunction()'])}}
                          {!! Form::close() !!}
                        </div>
                      @endif


                    </div>


                    @if(count($pats)>0)
                      <table class="table table-striped">
                        <tr>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Mobile</th>
                          <th>Amount Pending</th>
                          <th></th>
                          <th></th>
                          @if (auth()->user()->user_role == '1')
                            <th></th>
                          @endif
                        </tr>
                      @foreach($pats as $pat)
                        <tr>
                          <td> <a href="/TestProject/public/patients/{{$pat->id}}"><h5> {{ $pat->name }} </h5></a></td>
                          <td> {{ $pat->address}}</td>
                          <td> {{ $pat->mobile}}</td>

                          <td> {{$pat->amount_pending}}
                            @if ($pat->amount_pending != '0' && auth()->user()->user_role == '1')
                              {!! Form::open(['action'=>['PatientsController@updateStatus',$pat->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                                <input href="/TestProject/public/patients/update_status/{{$pat->id}}" type="image" alt="Close" class="submit" border="0" onclick="return functionChange()" src="/TestProject/public/storage/resources/edit1.png" width="20" height="20">
                              {!! Form::close() !!}
                            @endif

                            @php $amount_pending = $amount_pending + $pat->amount_pending @endphp

                          </td>
                          <td><a class="btn btn-primary" href="/TestProject/public/patient_records/create/{{$pat->id}}">Add Record</a></td>
                          <td> <a href="/TestProject/public/patients/{{$pat->id}}/edit">Edit</a> </td>

                          @if (auth()->user()->user_role == '1')

                            <th>
                              {!! Form::open(['action'=>['FamilyController@destroy',$pat->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                              {{  Form::hidden('_method','DELETE')}}
                              {{  Form::submit('Delete',['class'=>'btn btn-danger']) }}
                              {!! Form::close() !!}
                            </th>

                          @endif

                        </tr>
                      @endforeach
                      </table>

                      <div class="row" style="padding:10px">

                        <div class="col-md-6">
                          <h5>Total Amount Pending:<b> {{$amount_pending}} Rs</b></h5>
                        </div>

                      </div>

                    @else
                      <hr>
                      <center><p>No Patients added in this family !!</p></center>
                    @endif

                {{-- </div> --}}
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>
@endsection
