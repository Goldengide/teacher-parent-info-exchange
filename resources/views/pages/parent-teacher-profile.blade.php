@extends('layouts.parent')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{ $teacher->fullname }} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="{{ url('/parent/dashboard')}}">Dashboard</a></li>
            <!-- <li><a href="{{ url('/teacher/student')}}">Back to the Student's List</a></li> -->
            <li class="active"> {{ $teacher->fullname }} </li>
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
                <dt style="text-align: left; white-space: normal;">Parent Name:</dt> <dd>{{ $teacher->fullname }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Phone: </dt> <dd>{{ $teacher->phone }}</dd> <br><br>

                <dt style="text-align: left; white-space: normal;">Email: </dt> <dd>{{ $teacher->email }}</dd> <br></br>


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