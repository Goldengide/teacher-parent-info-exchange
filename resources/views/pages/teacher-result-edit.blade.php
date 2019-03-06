@extends('layouts.teachers')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">...</h4>
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Events</a></li>
            <li class="active">Add Event</li>
          </ol>
        </div> -->
        <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0">Edit Result</h3>
            @if(count($errors) > 0)

              <ul class="alert alert-danger">

                  @foreach($errors->all() as $error)

                     <li>{{$error}}</li>

                  @endforeach
              </ul>

            @endif
            
            @if(Session::has('message'))

              <p class="{{session('style')}}">{{session('message')}}</p>

            @endif

            <div class="row">
              <div class="col-md-12">
                <form class="form-material form-horizontal" method="post" action="{{url('teacher/result/edit')}}">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$result->id}}">
                  <div class="form-group">
                    <label class="col-md-12">Student's Name<span class="help"></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="student_name" value="{{$result->student($result->student_id)->student_name}}" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Parent's Name<span class="help"></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="parent_name" value="{{$result->student($result->student_id)->parent_name}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Assessment</label>
                    <div class="col-md-12">
                      <input type="number" class="form-control"  name="assessment" placeholder="Overall Assessment Score" value="{{$result->assessment}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Exam Score</label>
                    <div class="col-md-12">
                      <input type="number" class="form-control"  name="exam_score" placeholder="Exam Score" value="{{$result->exam_score}}">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-success">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->
  @endsection
  @section('other-scripts')
  <script src="{{URL::asset("plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
  <!-- Date range Plugin JavaScript -->
  <!-- <script src="{{URL::asset("plugins/bower_components/timepicker/bootstrap-timepicker.min.js")}}"></script> -->
 
  @endsection