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
            <?php $currentSeason = DB::table('seasons')->where('current', 1)->first(); ?>
            <li><a href="{{ url('super-admin/dashboard')}}">Dashboard</a></li>
            <li class="active">{{$currentSeason->session}} |{{$currentSeason->term_no}}|</li>
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
                <dt style="text-align: left; white-space: normal;">Class :</dt> <dd>{{ strtoupper($class->name) }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Teacher: </dt> 
                <dd> 
                @if($class->teacher_id > 0)
                  {{ strtoupper($class->teacher($class->teacher_id)->lastname) }}, {{ $class->teacher($class->teacher_id)->firstname }}
                  <a href="{{ url('/super-admin/classes/assign-teacher/'. $class->id) }}">(Change Teacher)</a>
                @else 
                  <a href="{{ url('/super-admin/classes/assign-teacher/'. $class->id) }}">Assign Teacher</a>
                @endif
                </dd>  <br><br>
                <dt style="text-align: left; white-space: normal;">No Of Students: </dt> <dd>{{$noOfStudents}}</dd> <br></br>
                <dt style="text-align: left; white-space: normal;"><a href="{{url('/super-admin/classes')}}" class="btn btn-lg btn-info">Go Back</a></dt> <dd></dd> <br></br>
                      



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
@section('title')
  <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
    <h4 class="page-title">{{strtoupper($class->name)}} Class</h4>
  </div>
@endsection