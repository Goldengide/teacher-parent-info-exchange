@extends('layouts.super-admin')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">...</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <?php $currentSeason = DB::table('seasons')->where('current', 1)->first(); $seasonIsSet = DB::table('seasons')->where('current', 1)->count();?>
            <li><a href="{{ url('super-admin/dashboard')}}">Dashboard</a></li>
            @if(!$seasonIsSet)
              <li class="active">---</li>
              
            @else
              <li class="active">{{$currentSeason->session}} |{{$currentSeason->term_no}}|</li>
            @endif
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
        <!-- /row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
            <h3 class="box-title m-b-0">Classes</h3>
            @if(!isset($results) || empty($results))
                
                <p class="text-muted m-b-30"><a href="{{url('/super-admin/classes/new')}}">Add New Class</a></p>
                <p class="text-muted m-b-30"><a href="{{url('/super-admin/classes/upload')}}">Upload Classes</a></p>
            
            @endif
            @if(Session::has('message'))

              <p class="{{session('style')}}">{{session('message')}}</p>

            @endif
            <div class="table-responsive">
            <table id="myTable" class="table table-striped">
              <thead>
                <tr>
                  <th>Class Name</th>
                  @if(!isset($results) && empty($results))
                    <th>Teacher Assigned</th>
                    <th>Action</th>
                  @endif
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Class Name</th>
                  @if(!isset($results) && empty($results))
                    <th>Teacher Assigned</th>
                    <th>Action</th>
                  @endif
                </tr>
              </tfoot>
              <tbody>
                @if(count($classes) < 1)
                  <td colspan="5">No Classes data has been uploaded so far. Please upload</td>
                @else
                  @foreach($classes as $class)
                  <tr>
                    <td><a href="{{ url('super-admin/result/season/'. $season->id. '/class/'. $class->id)}}">{{strtoupper($class->name)}}</a></td>
                    @if(!isset($results) && empty($results))
                      
                      <td>
                        @if($class->teacher_id == 0)
                          <a href="{{ url('/super-admin/classes/assign-teacher/'. $class->id) }}" class="text-primary">Unassigned</a>
                        @else
                          <a href="{{ url('/super-admin/teacher/profile/'. $class->teacher_id) }}" class="text-info">{{$class->teacher($class->teacher_id)->fullname}} </a>
                        @endif
                      </td>

                    

                      <td>
                      
                        <a href="{{url('super-admin/classes/view/'. $class->id)}}" class="text-primary"><i class="icon icon-user"></i></a> | 
                        <a href="{{url('super-admin/classes/edit/'. $class->id)}}" class="text-primary"><i class="icon icon-pencil"></i></a>
                      
                      </td> 
                    @endif
                    
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
@section('title')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">{{'title'}}</h4>
  </div>
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