@extends('layouts.super-admin')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Mr. {{strtoupper($teacher->lastname)}} {{$teacher->firstname}} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="{{ url('/super-admin/dashboard')}}">Dashboard</a></li>
            <li><a href="{{ url('/super-admin/teachers')}}">Back to the Teacher's List</a></li>
            <li class="active"> {{$teacher->firstname}} </li>
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
                <dt style="text-align: left; white-space: normal;">Last Name:</dt> <dd>{{ $teacher->lastname }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">First Name: </dt> <dd> {{ $teacher->firstname }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Other Names: </dt> <dd>{{ $teacher->othernames }}</dd> <br></br>

              </dl>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-5">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <dl class="dl-horizontal">
                
                <dt style="text-align: left; white-space: normal;">Assigned Class: </dt> <dd>J5</dd> <br></br>

                <dt style="text-align: left; white-space: normal;">Phone:</dt> <dd>{{ $teacher->phone }}</dd> <br><br>

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