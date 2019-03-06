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
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0">Edit Student</h3>
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
                <form class="form-material form-horizontal" method="post" action="{{url('super-admin/student/edit')}}">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{ $student->id}}">
                  <div class="form-group">
                    <label class="col-md-12">Student's Name<span class="help"> e.g Awosanmi Awoyelu</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="student_name" value="{{$student->student_name}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Parent's Name<span class="help"> e.g Mr & Mrs. Awosanmi</span></label>
                    <div class="col-md-12">
                      <input type="text" class="form-control form-control-line" name="parent_name" value="{{ $student->parent_name }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Phone Number</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control"  name="phone" value="{{ $student->phone }}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-12">Email</label>
                    <div class="col-md-12">
                      <input type="text" class="form-control"  name="email" value="{{ $student->email }}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-12">Sex</label>
                    <div class="col-md-12">
                      <select class="form-control" name="gender">
                        <option value="{{$student->gender}}" selected>Gender: {{ strtoupper($student->gender)}}</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <label class="col-md-12">Class</label>
                    <div class="col-md-12">
                      <select class="form-control" name="class_id">
                        <option value="{{$student->class_id}}" selected>Class: {{strtoupper($student->classTable($student->class_id)->name)}}</option>
                        @foreach ($classes as $class)
                          <option value="{{$class->id}}">{{strtoupper($class->name)}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-success">Submit</button>
                      <a href="{{url('/super-admin/students')}}" class="btn btn-lg btn-outline btn-default">Go Back</a>
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
  </div>
  <!-- /#page-wrapper -->
@endsection
@section('other-scripts')
  <script src="{{URL::asset("plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js")}}"></script>
  <!-- Date range Plugin JavaScript -->
  <!-- <script src="{{URL::asset("plugins/bower_components/timepicker/bootstrap-timepicker.min.js")}}"></script> -->
 
@endsection

