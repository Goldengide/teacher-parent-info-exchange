@extends('layouts.parent')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{ $child->student_name }} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            
              <!-- <li><a href="{{ url('/parent/dashboard')}}">Dashboard</a></li> -->
            @if($countChildren > 1)
              
              <li><a href="{{ url('/parent/children')}}">Back to the Student's List</a></li>
            
            @endif
            
            <li class="active"> {{ $child->student_name }} </li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12 col-md-3">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                <dt style="text-align: center; white-space: normal;">
                  <img src="{{ URL::asset('uploads/images/'. $child->img_url)}}" class="img-responsive img-center img-circle" align="center" >
                </dt> 
                <dd></dd>  <br><br>
                <form action="{{ url('/parent/child/profile/pics') }}" id = "change-profile-pics" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <input type="hidden" name="id" value="{{$child->id}}">
                  <input type="file" name="photo" class="form-control">
                  <button type="submit" class="btn btn-primary col-xs-12">Upload</button>
                </form>
                <dt style="text-align: center;"><a href="#change-profile-pics" class="user-clicker-change">Change Profile Pics</a></dt>  <br><br>
                
              </dl>
              
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-5">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                <dt style="text-align: left; white-space: normal;">Child Name:</dt> <dd>{{ $child->student_name }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Class: </dt> <dd>{{ strtoupper($child->classTable($child->class_id)->name) }}</dd> <br></br>

                <dt style="text-align: left; white-space: normal;">Teacher </dt> <dd> {{ $child->classTable($child->class_id)->teacher->fullname }}<a href="{{url('/parent/teacher/profile/'. $child->classTable($child->class_id)->teacher->id)}}"><i class="icon icon-user"></i></a></dd> <br></br>
                @if($showResult)
                <dt style="text-align: left; white-space: normal;"><a href="{{ url('/parent/child/result/'.$child->id)}}">Check Result</a></dt> <br></br>
                @endif

              </dl>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                
                <dt style="text-align: left; white-space: normal;">My Name: </dt> <dd><a href="{{ url('/teacher/parent/profile/'. $child->parent($child->id)) }}">{{ $child->parent_name }}</a></dd> <br></br>

                <dt style="text-align: left; white-space: normal;">Phone: </dt> <dd>{{ $child->phone }}</dd> <br><br>

                <dt style="text-align: left; white-space: normal;">Email: </dt> <dd>{{ $child->email }}</dd> <br></br>

              </dl>
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
    <script>
      $(document).ready(function(){
        $('#change-profile-pics').hide();
        $('.user-clicker-change').mousedown(function() {
          $('#change-profile-pics').show();
          $('.user-clicker-change').hide();
        })
      });
      
    </script>
  @endsection