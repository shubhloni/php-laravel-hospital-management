@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="padding:10px">
                      @if (auth()->user()->user_role == '3')
                        <h5 style="color:red">User Id Not Authorized to access other information...<br> Please get it Approved by Admin</h5>
                      @endif
                    </div>

                    <div class="row" style="padding:10px">

                      <div class="col-md-1">
                      </div>
                      <div class="col-md-4" style="border:2px solid black; padding:10px">
                        <h5 class="" align="center">Number of Families<br>(registered)</h5>
                        <br>
                        <h2 align="center">{{ $fam_count }}</h2>
                      </div>
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-4" style="border:2px solid black; padding:10px">
                        <h5 class="" align="center">Number of Patients<br>(registered)</h5>
                        <br>
                        <h2 align="center">{{ $pat_count }}</h2>
                      </div>
                      <div class="col-md-1">
                      </div>

                    </div>

                    <div class="row" style="padding:10px">

                      <div class="col-md-1">
                      </div>
                      <div class="col-md-4" style="border:2px solid black; padding:10px">
                        <h5 class="" align="center">Patients Admitted<br>(current count)</h5>
                        <br>
                        <h2 align="center">{{ $pat_admit }}</h2>
                      </div>
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-4" style="border:2px solid black; padding:10px">
                        <h5 class="" align="center">Amount Pending<br>(current count)</h5>
                        <br>
                        <h2 align="center">{{ $amount_pending }} Rs</h2>
                      </div>
                      <div class="col-md-1">
                      </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
