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
                <div class="card-header"><h3>Users</h3></div>

                {{-- <div class="card-body"> --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- <div class="row" style="padding:10px">

                      <div class="col-md-2">
                        <a href="/TestProject/public/auth/add_user" class="btn btn-primary">Add User</a>
                      </div>

                    </div> --}}


                    @if(count($users)>0)
                      <table class="table table-striped">
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Address</th>
                          <th>Role</th>
                          @if (auth()->user()->user_role == '1')
                            <th></th>
                            <th></th>
                          @endif
                          {{-- <th></th> --}}
                        </tr>

                      @foreach($users as $user)
                        <tr>
                          <td> {{ $user->name}} </a></td>
                          <td> {{ $user->email}} </td>
                          <td> {{ $user->mobile}}  </td>
                          <td> {{ $user->address}}  </td>
                          <td>
                            @if ($user->user_role == '1')
                              Admin
                            @elseif ($user->user_role == '2')
                              Non-Admin
                            @else
                              Blocked
                            @endif
                          </td>
                          @if (auth()->user()->user_role == '1')
                            <td><a href="user/{{$user->id}}/edit"> Edit </a></td>
                            <th>
                              {!! Form::open(['action'=>['UserController@destroy',$user->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                              {{  Form::hidden('_method','DELETE')}}
                              {{  Form::submit('Delete',['class'=>'btn btn-danger','onclick'=>'return myFunction()'])}}
                              {!! Form::close() !!}
                            </th>
                          @endif

                        </tr>
                      @endforeach
                      </table>
                    @else
                      <p>No Users, Add New !!</p>
                    @endif

                {{-- </div> --}}
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>

@endsection
