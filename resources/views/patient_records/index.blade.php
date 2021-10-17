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

<script type="text/javascript">
$('#myModalHorizontal').on('show', function(e) {
  var link     = e.relatedTarget(),
      modal    = $(this),
      title    = link.data("title"),
      id       = link.data("id");

  modal.find("#title").val(title);
  modal.find("#id").val(id);
});
</script>

@php
  $amount_pending = 0;
  $amount_paid = 0;
  $pat_records_gv = null;
  $pat_records_close = null;
  $key = 1;

  $pat_records_gv = clone $pat_records;
  $pat_records_close = clone $pat_records;

  if(isset($_GET['showOpen'])) {
      // if ($key == 1){
      //   $key = 2;
      //  }
      $key  = 1;
      // header('Location: '.$_SERVER['REQUEST_URI']);
    }
    if(isset($_GET['showClose'])) {
        $key = 2;
        // header('Location: '.$_SERVER['REQUEST_URI']);
      }

  if(count($pat_records)>0){

    foreach($pat_records as $subKey => $subArray){
          if($subArray['payment_status'] == '2'){
               unset($pat_records[$subKey]);
          }
     }

     foreach($pat_records_close as $subKey1 => $subArray1){
           if($subArray1['payment_status'] == '1'){
                unset($pat_records_close[$subKey1]);
           }
      }
  }

@endphp

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center"> --}}
        {{-- <div class="col-md-8"> --}}
            <div class="card" style="padding:10px">
                <div class="card-header"><h3>{{ $pat->name }} - Patient's Records</h3></div>

                {{-- <div class="card-body"> --}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row" style="padding:10px">

                      <div class="col-md-2">
                        <a href="/TestProject/public/family/{{$pat->family_id}}" class="btn">Back</a>
                      </div>

                      <div class="col-md-2">
                        <form method="GET">
                          <input type="submit" class="btn" name="showClose" value="Show Closed"/>
                        </form>
                      </div>

                      <div class="col-md-2">
                        <form method="GET">
                          <input type="submit" class="btn" name="showOpen" value="Show Open"/>
                        </form>
                      </div>
                      <div class="col-md-2">
                        <a href="/TestProject/public/patient_records/create/{{$pat->id}}" class="btn btn-primary">New Record</a>
                      </div>

                    </div>

                    @if(count($pat_records_gv)>0)

                      <table class="table table-striped">
                        <tr>
                          <th> Admit Date </th>
                          <th> Title      </th>
                          <th> Details    </th>
                          <th> Amount(Rs) </th>
                          <th> Status     </th>
                          <th> Created by </th>
                          <th> Created at </th>
                          <th> Updated by </th>
                          <th> Updated at </th>
                          @if ($key == '1')
                          <th></th>
                          @endif

                        </tr>


                        @if ($key == '1')



                      @foreach($pat_records as $pat_record)
                        <tr>
                          <td>{{ $pat_record->admit_date }}</td>
                          <td>
                            @if (auth()->user()->user_role == '1')
                              <a href="/TestProject/public/patient_records/{{$pat_record->id}}/edit"> {{ $pat_record->record_title }} </a>
                            @endif
                          </td>
                          <td>{{ $pat_record->details }}</td>


                               @if ($pat_record->payment_status == '1')

                                 <td style="color:green">{{ $pat_record->treat_amount }}</td>
                                 <td style="color:green"> Open </td>
                                @php $amount_pending = $amount_pending + $pat_record->treat_amount @endphp

                              @elseif ($pat_record->payment_status == '2')

                                <td style="color:red">{{ $pat_record->treat_amount }}</td>
                                <td style="color:red"> Close </td>
                                @php $amount_paid = $amount_paid + $pat_record->treat_amount @endphp

                               @endif

                          <td>{{ $pat_record->created_by }}</td>
                          <td>{{ $pat_record->created_at }}</td>
                          <td>{{ $pat_record->updated_by }}</td>
                          <td>{{ $pat_record->updated_at }}</td>
                          @if ($key == '1')
                            <th>
                              {!! Form::open(['action'=>['PatientRecordController@updateStatus',$pat_record->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                                <input href="/TestProject/public/patient_records/update_status/{{$pat_record->id}}" type="image" class="submit" border="0" onclick="return functionChange()" alt="Update" src="/TestProject/public/storage/resources/edit1.png" width="20" height="20">
                              {!! Form::close() !!}
                            </th>
                          @endif

                        </tr>
                      @endforeach

                        @endif


                        @if ($key == '2')



                      @foreach($pat_records_close as $pat_record)
                        <tr>
                          <td>{{ $pat_record->admit_date }}</td>
                          <td>{{ $pat_record->record_title }}</td>
                          <td>{{ $pat_record->details }}</td>


                               @if ($pat_record->payment_status == '1')

                                 <td style="color:green">{{ $pat_record->treat_amount }}</td>
                                 <td style="color:green"> Open </td>
                                @php $amount_pending = $amount_pending + $pat_record->treat_amount @endphp

                              @elseif ($pat_record->payment_status == '2')

                                <td style="color:red">{{ $pat_record->treat_amount }}</td>
                                <td style="color:red"> Close </td>
                                @php $amount_paid = $amount_paid + $pat_record->treat_amount @endphp

                               @endif

                          <td>{{ $pat_record->created_by }}</td>
                          <td>{{ $pat_record->created_at }}</td>
                          <td>{{ $pat_record->updated_by }}</td>
                          <td>{{ $pat_record->updated_at }}</td>
                          {{-- <th> <a href="#">Change</a> </td> --}}

                        </tr>
                      @endforeach

                        @endif

                      </table>

                      <div class="row" style="padding:10px">

                      @if ($key == '1')
                        <div class="col-md-6">
                          <h5>Total Amount Pending:<b> {{$amount_pending}} Rs</b></h5>
                        </div>
                      @endif

                      @if ($key == '2')
                        <div class="col-md-6">
                          <h5>Total Amount Paid:<b> {{$amount_paid}} Rs</b></h5>
                        </div>
                      @endif

                      </div>

                    @else
                      <p>No Patient Records !!</p>
                    @endif



                {{-- </div> --}}
            </div>
        </div>
        {{-- </div> --}}
    {{-- </div> --}}
</div>



<!-- Modal -->
{{-- <div class="modal fade" id="myModalHorizontal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">

    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header" style="background: rgba(0, 0, 0, 0.05)">
            <h3 class="modal-title" id="myModalLabel" style="color: black;">Settle Amount and Close Status</h3>
        </div>            <!-- Modal Body -->
        <div class="modal-body">

            <form id="frm-donation" name="frm-donation">
                <div class="header-btn">
                    <div id="div-physical">

                      <input type="text" name="title" id="title">
                      <input type="text" name="id" id="id">

                    </div>
                </div>
            </form>
            <div class="modal-body">
                <div class="modal-footer" id="modal_footer">
                    <!--<input id="btnSubmit" name="btnSubmit" value="Donate" class="btn btn-default-border-blk" type="submit">-->
                    {!! Form::open(['action'=>['PatientRecordController@destroy',$pat_record->id], 'method'=>'POST', 'class'=>'pull-right']) !!}
                    {{  Form::hidden('_method','DELETE')}}
                    {{  Form::submit('Delete',['class'=>'btn btn-danger'])}}
                    {!! Form::close() !!}
                    <a href='#' class="btn btn-primary">Update</a>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
