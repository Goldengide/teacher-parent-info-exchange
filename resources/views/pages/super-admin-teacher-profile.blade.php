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
                
                <dt style="text-align: left; white-space: normal;">Assigned Class: </dt> 
                <dd>
                  @if(empty($class))
                  <a href="{{ url('/super-admin/teacher/assign-class/'. $teacher->id) }}">Assign A Class</a>
                  @else
                  {{strtoupper($class->name)}} <a href="{{ url('/super-admin/teacher/assign-class/'. $class->teacher_id) }}">(Change Class)</a>
                  @endif
                </dd> <br></br>

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