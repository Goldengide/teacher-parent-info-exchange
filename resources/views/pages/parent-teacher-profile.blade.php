@extends('layouts.teachers')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{ $parent->fullname }} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="{{ url('/teacher/dashboard')}}">Dashboard</a></li>
            <li><a href="{{ url('/teacher/student')}}">Back to the Student's List</a></li>
            <li class="active"> {{ $parent->fullname }} </li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12 col-md-7">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                <dt style="text-align: left; white-space: normal;">Parent Name:</dt> <dd>{{ $parent->fullname }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Phone: </dt> <dd>{{ $parent->phone }}</dd> <br><br>

                <dt style="text-align: left; white-space: normal;">Email: </dt> <dd>{{ $parent->email }}</dd> <br></br>


              </dl>
            </div>
          </div>
        </div>
        @if($countChildren > 0)
          <div class="col-sm-12 col-md-5">
            <div class="white-box p-l-20 p-r-20">
              <div class="row">
                <dl class="dl-horizontal">

                  <dt style="text-align: left; white-space: normal;">No of Children In School </dt> <dd>{{ $countChildren }}</dd> <br></br>

                  @foreach($students as $student)
                  
                    <dt style="text-align: left; white-space: normal;"></dt> <dd><a href="{{ url('/teacher/student/profile/'. $student->student_id) }}">See {{ $student->student_name }} Profile</a></dd> <br></br>

                    

                  @endforeach

                </dl>
              </div>
            </div>
          </div>

        @endif
      </div>
      <!-- /.row -->
      
      
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->

  @endsection 