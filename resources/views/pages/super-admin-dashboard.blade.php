@extends('layouts.super-admin')
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="{{url('/teacher/students')}}">{{$noOfTeachers}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Teachers</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="">{{$noOfStudents}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Students in School</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary">0</h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Graduating Students</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary">0</h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">New Students</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
      </div>
      <!--row -->

      <!-- /.row -->
      <div class="row">

        <div class="col-md-3 col-lg-3 col-sm-6">
          <div class="white-box">
            <div class="row">
              <div class="col-xs-12">
                <div class="col-in row">
                  <div class="col-xs-12">
                    <!-- <h5 class="counter text-center m-t-15 text-primary"><a href="{{url('/teacher/students')}}">Click to see</a></h5> -->
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Best Students</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="{{url('/teacher/students')}}">0%</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Best Overall Score</h4>
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
                    <h5 class="counter text-center m-t-15 text-primary"><a href=""></a></h5>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Most Effective Teacher</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="">0</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">New Messages</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        
      </div>
      <!--row -->

      <!-- /.row -->
      <!-- <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-6">
          <div class="white-box">
            <div class="row">
              <div class="col-xs-12">
                <div class="col-in row">
                  <div class="col-xs-12">
                    <h3 class="counter text-center m-t-15 text-primary"><a href="{{url('/super-admin/upload/')}}">?</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Upload Result</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary">??</h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">Graduating Students</h4>
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="{{url('/teacher/students')}}">{{$noOfTeachers}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb"></h4>
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
                    <h3 class="counter text-center m-t-15 text-primary"><a href="">{{$noOfStudents}}</a></h3>
                  </div>
                  <div class="col-xs-12">
                    <h4 class="text-muted text-center text-info vb">All Students</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!--row -->
      
@endsection