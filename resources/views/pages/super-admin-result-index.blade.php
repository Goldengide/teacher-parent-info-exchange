@extends('layouts.super-admin')
@section('content')
  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{strtoupper($class->name)}}</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <!-- <a href="https://themeforest.net/item/elite-admin-responsive-dashboard-web-app-kit-/16750820" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Buy Now</a> -->
          <ol class="breadcrumb">
            <?php $currentSeason = DB::table('seasons')->where('current', 1)->first(); ?>
            <li><a href="{{ url('teacher/dashboard')}}">Dashboard</a></li>
            <li class="active">{{$currentSeason->session}} |{{$currentSeason->term_no}}|</li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
            <h3 class="box-title m-b-0">Subject: {{$subject->name}}</h3>
            <h3 class="box-title m-b-0">Class: {{$class->name}}</h3>
            <h3 class="box-title m-b-0">
                @if($results[1]->approved) 
                  This result has been approved <i class="icon icon-mark"></i>
                @endif
            </h3>
            @if(Session::has('message'))

              <p class="{{session('style')}}">{{session('message')}}</p>

            @endif
            <div class="table-responsive">
            <table id="myTable" class="table table-striped">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Assessment</th>
                  <th>Exam Score</th>
                  <th>Total</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Average Score: {{$resultAverage}}</th>
                  <th> </th>
                  <th>
                    <form method="post" action="{{url('super-admin/result/approve')}}">
                      {{csrf_field()}}
                      <input type="hidden" name="class_id" value="{{$class->id}}">
                      <input type="hidden" name="subject_id" value="{{$subject->id}}">
                      <input type="hidden" name="season_id" value="{{$season->id}}">
                      <button class="btn btn-md btn-outline btn-success" type="submit">Approve Result</button>
                    </form>
                  </th>
                  <th></th>
                  <!-- <th><form method="post" action="{{url('super-admin/result/reject')}}">
                      {{csrf_field()}}
                      <input type="hidden" name="class_id" value="{{$class->id}}">
                      <input type="hidden" name="subject_id" value="{{$subject->id}}">
                      <input type="hidden" name="season_id" value="{{$season->id}}">
                      <button class="btn btn-md btn-outline btn-success" type="submit">Approve Result</button>
                    </form>
                  </th> -->
                </tr>
              </tfoot>
              <tbody>
                @if(count($results) < 1)
                  <td colspan="5">No student data has been uploaded so far. Please upload</td>
                @else
                  @foreach($results as $result)
                  <tr>
                    <td>{{$result->student($result->student_id)->student_name}}</td>
                    <td>{{$result->assessment}}</td>
                    <td>{{$result->exam_score}}</td>
                    <td>{{intval($result->assessment) + intval($result->exam_score)}}</td>
                    <!-- <td> -->
                      <!-- <a href="{{url('super-admin/result/edit/'. $result->id)}}" class="text-info"><i class="icon icon-pencil"></i></a>   -->
                        <!-- <a href="{{url('teacher/result/view/'. $result->id )}}" class="text-info"><i class="ti-user"></i>View Result</a> -->
                    <!-- </td>  -->
                    
                  </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
@endsection
@section('other-scripts')
  <script src="{{ URL::asset("plugins/bower_components/datatables/jquery.dataTables.min.js") }}"></script>

  <!-- start - This is for export functionality only -->
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
  <script>
      $(document).ready(function(){
        $('#myTable').DataTable();
        $(document).ready(function() {
          var table = $('#example').DataTable({
            "columnDefs": [
            { "visible": false, "targets": 2 }
            ],
            "order": [[ 2, 'asc' ]],
            "displayLength": 25,
            "drawCallback": function ( settings ) {
              var api = this.api();
              var rows = api.rows( {page:'current'} ).nodes();
              var last=null;

              api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                  $(rows).eq( i ).before(
                    '<tr class="group"><td colspan="5">'+group+'</td></tr>'
                    );

                  last = group;
                }
              } );
            }
          } );

          // Order by the grouping
          $('#example tbody').on( 'click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
              table.order( [ 2, 'desc' ] ).draw();
            }
            else {
              table.order( [ 2, 'asc' ] ).draw();
            }
          });
        });
      });
      $('#example23').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ]
      });
    </script>

@endsection
@section('other-styles')
  <link href="{{ URL::asset("plugins/bower_components/datatables/jquery.dataTables.min.css") }}" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection