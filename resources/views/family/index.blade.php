@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center"> --}}
        {{-- <div class="col-md-8"> --}}
            <div class="card" style="padding:10px">
                <div class="card-header"><h3>Family Data</h3></div>

                {{-- <div class="card-body"> --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="padding:10px">

                      {{-- <div class="col-md-2">
                        <a href="/TestProject/public/" class="btn">Go Back</a>
                      </div> --}}

                      <div class="col-md-2">
                        <a href="/TestProject/public/family/create" class="btn btn-primary">Add Family</a>
                      </div>


                    </div>


                    @if(count($fams)>0)
                      <table class="table table-striped">
                        <tr>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Mobile</th>
                          <th>Referance</th>
                          {{-- <th>Amount</th> --}}
                          @if (auth()->user()->user_role == '1')
                            <th></th>
                          @endif
                        </tr>
                      @foreach($fams as $fam)

                        <tr>
                          <td><a href="/TestProject/public/family/{{$fam->id}}"><h5> {{ $fam->name }} </h5></a></td>
                          <td>{{$fam->address}}</td>
                          <td>{{$fam->mobile}}</td>
                          <td>{{$fam->referance}}</td>
                          {{-- <td>{{$fam->amount_pending}}</td> --}}
                          @if (auth()->user()->user_role == '1')
                            <td> <a href="/TestProject/public/family/{{$fam->id}}/edit">Edit</a> </td>
                          @endif


                        </tr>
                      @endforeach
                      </table>
                    @else
                      <p>No Families, Add New !!</p>
                    @endif

                {{-- </div> --}}
            {{-- </div> --}}
        </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>
@endsection
