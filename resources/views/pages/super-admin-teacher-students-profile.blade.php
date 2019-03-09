@extends('layouts.super-admin')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{ $student->student_name }} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="{{ url('/teacher/dashboard')}}">Dashboard</a></li>
            <li><a href="{{ url('/teacher/student')}}">Back to the Student's List</a></li>
            <li class="active"> {{ $student->student_name }} </li>
          </ol>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12 col-md-2">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                <dt style="text-align: left; white-space: normal;">
                  <img class="img-responsive" src="{{ URL::asset('uploads/images/'. $student->img_url)}}">
                </dt> 
                
              </dl>
              
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-5">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                <dt style="text-align: left; white-space: normal;">Student Name:</dt> <dd>{{ $student->student_name }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Class: </dt> <dd>{{ strtoupper($student->classTable($student->class_id)->name) }}</dd> <br></br>

                <dt style="text-align: left; white-space: normal;">Teacher </dt> <dd>{{ $student->classTable($student->class_id)->teacher($student->classTable($student->class_id)->teacher_id)->fullname }}</dd> <br></br>

              </dl>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-5">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                
                <dt style="text-align: left; white-space: normal;">Parent Name: </dt> <dd><a href="{{ url('/teacher/parent/profile/'. $student->parent($student->parent_name)->id) }}">{{ $student->parent_name }} <i class="icon icon-envelope"></i></a></dd> <br></br>

                <dt style="text-align: left; white-space: normal;">Phone: </dt> <dd>{{ $student->phone }}</dd> <br><br>

                <dt style="text-align: left; white-space: normal;">Email: </dt> <dd>{{ $student->email }}</dd> <br></br>
                @if($isProcessedResult)
                  <a href="{{ url('super-admin/result/student/'. $season->id .'/'. $student->class_id .'/'. $student->id) }}">Check Result</a>
                @endif

              </dl>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <!-- .row -->
      
      <!-- /.row -->
      
      
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->

  @endsection 