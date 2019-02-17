@extends('layouts.teachers')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">  </h4>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-6">
          <div class="white-box">
            <div class="row">
              <div class="col-xs-12">
                <div class="col-in row">
                  <div class="col-xs-12">
                    <h3 class="counter text-center m-t-15 text-primary"><a href="{{url('/teacher/students')}}">{{22}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Students</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-lg-3 col-sm-6">
          <div class="white-box">
            <div class="row">
              <div class="col-xs-12">
                <div class="col-in row">
                  <div class="col-xs-12">
                    <h3 class="counter text-center m-t-15 text-primary"><a href="">{{22}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Subjects</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--row -->
      
@endsection