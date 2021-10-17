@extends('layouts.app')

<script>

var patName = null;
function myFunction(pat) {

  if(!confirm("Do you really want to Delete?")) {
    return false;
  }
  this.form.submit();
}

function functionChange() {

  if(!confirm("Do you really want to Close Payment Status?")) {
    return false;
  }
  this.form.submit();
}

</script>

@section('content')

<div class="container">

    {{-- <div class="row justify-content-center"> --}}
        {{-- <div class="col-md-8"> --}}
            <div class="card" style="padding:10px">
                <div class="card-header"><h3>Patients Data</h3></div>

                {{-- <div class="card-body"> --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="padding:10px">

                      <div class="col-md-2">
                        <a href="/TestProject/public/patients/create" class="btn btn-primary">Add Patient</a>
                      </div>

                    </div>


                    @if(count($pats)>0)
                      <table class="table table-striped">
                        <tr>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Mobile</th>
                          <th>Family</th>
                          <th>Amount Pending</th>
                          <th></th>
                          {{-- <th></th> --}}
                        </tr>

                        @php
                          if (count($fams)>0) {
                            // code...
                             // $family = (array) $fams;
                             $family = json_decode($fams, true);
                          }
                        @endphp
                      @foreach($pats as $pat)
                        <tr>
                          <td><a href="/TestProject/public/patients/{{$pat->id}}"> {{ $pat->name}} </a></td>
                          <td> {{ $pat->address}} </td>
                          <td> {{ $pat->mobile}} </td>
                          {{-- @foreach($fams as $fam) --}}
                             {{-- @if($fam->id == $pat->family_id) --}}
                               @php
                                 $fam = array_search($pat->family_id, array_column($family, 'id'));
                               @endphp
                               <td><a href="/TestProject/public/family/{{$pat->family_id}}"> {{ $family[$fam]['name'] }}</a></td>
                             {{-- @endif --}}
                          {{-- @endforeach --}}

                          <td> {{$pat->amount_pending}}

                            @if ($pat->amount_pending != '0' && auth()->user()->user_role == '1')
                              {!! Form::open(['action'=>['PatientsController@updateStatus',$pat->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                                <input href="/TestProject/public/patients/update_status/{{$pat->id}}" type="image" alt="Close" class="submit" border="0" onclick="return functionChange()" src="/TestProject/public/storage/resources/edit1.png" width="20" height="20">
                              {!! Form::close() !!}
                            @endif
                          </td>
                          <th> <a class="btn btn-primary" href="/TestProject/public/patient_records/create/{{$pat->id}}">Add Record</a> </td>
                          {{-- <th>

                            {!! Form::open(['action'=>['PatientsController@destroy',$pat->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                            {{  Form::hidden('_method','DELETE')}}
                            {{  Form::submit('Delete',['class'=>'btn btn-danger','onclick'=>'return myFunction()'])}}
                            {!! Form::close() !!}
                          </th> --}}
                        </tr>
                      @endforeach
                      </table>
                    @else
                      <p>No Patients, Add New !!</p>
                    @endif

                {{-- </div> --}}
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>

@endsection
