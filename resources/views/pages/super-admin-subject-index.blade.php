@extends('layouts.super-admin')
@section('content')
  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">
            @if(isset($results) && $results == true)
              {{strtoupper($class->name)}}
            @endif
          </h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <!-- <a href="https://themeforest.net/item/elite-admin-responsive-dashboard-web-app-kit-/16750820" target="_blank" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">Buy Now</a> -->
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
            @if(!$isProcessedResult)
              @if(isset($isAllResultsHasBeenUploadedForEachStudent) && $isAllResultsHasBeenUploadedForEachStudent)
                <h3 class="box-title m-b-0">
                  <form method="post" action="{{url('super-admin/result/process')}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="class_id", value="{{$class->id}}">
                    <input type="hidden" name="season_id", value="{{$season->id}}">
                    <button class="btn btn-md btn-info" type="submit">Process Result</button>
                  </form>
                </h3>
              @endif
            @endif
            <h3 class="box-title m-b-0">Subjects</h3>
            @if(!isset($results) || empty($results))
              
              <p class="text-muted m-b-30"><a href="{{url('/super-admin/subject/upload')}}">Upload Subjects</a></p>
              <p class="text-muted m-b-30"><a href="{{url('/super-admin/subject/new')}}">Add New Subject</a></p>
            @else
              <p class="text-muted m-b-20">
                <span class="text-info">Uploaded Result: {{$uploadedSubjectsResult}}/{{$overallSubjects}}</span>
                @if(isset($isAllResultsHasBeenUploadedForEachStudent) && $isAllResultsHasBeenUploadedForEachStudent)
                  <span class="text-primary">(Result ready to Process)</span>
                @else
                  <span class="text-primary">(At complete uploading of results, a button will show up to summarize all students final report)</span>
                @endif
              </p>
            @endif
            @if(Session::has('message'))

              <p class="{{session('style')}}">{{session('message')}}</p>

            @endif
            <div class="table-responsive">
            <table id="myTable" class="table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Short Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Short Name</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @if(count($subjects) < 1)
                  <td colspan="2">No subject data has been uploaded so far. Please upload</td>
                @else
                  @foreach($subjects as $subject)
                  <tr>
                    <td>{{$subject->name}}</td>
                    <td>{{$subject->short_name}}</td>
                    <td>
                      @if(!isset($results) && empty($results))
                          <a href="{{url('super-admin/subject/edit/'. $subject->id)}}" class="text-primary"><i class="icon icon-pencil"></i></a>
                      @else
                        
                        @if($subject->result($class->id, $subject->id, $season->id)->times_uploaded > 0)
                          <span class="text-default">[{{$subject->result($class->id, $subject->id, $season->id)->times_uploaded}}]  |</span>
                          <a href="{{url('super-admin/result/view/' .$season->id. '/'. $class->id. '/' .$subject->id )}}" class="text-info" title="View Result"><i class="icon icon-eye"></i></a>
                        @else
                          Not yet Uploaded
                        @endif
                      
                      @endif
                    </td> 
                    
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