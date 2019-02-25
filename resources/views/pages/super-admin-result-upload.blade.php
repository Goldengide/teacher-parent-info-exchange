@extends('layouts.super-admin')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">...</h4>
        </div>
        <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Events</a></li>
            <li class="active">Add Event</li>
          </ol>
        </div> -->
        <!-- /.col-lg-12 -->
      </div>
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0">Upload Result</h3>
            @if(count($errors) > 0)

              <ul class="alert alert-danger" style="padding-left: 1em;">

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
                <form class="form-material form-horizontal" method="post" action="{{url('super-admin/result/upload')}}" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label class="col-md-12">Subject File<span class="help"> e.g upload a CSV file.</span> 
                      <a href="{{ url('/super-admin/template/result/'. $season->id  .'/'. $class->id  .'/'. $subject->id  .'/'. trim( $subject->name .'_result_for_'. strtoupper($class->name). '_'. implode('_', explode('/', $season->session)) .'_Term_'. $season->term_no) . '.csv') }}"> Download Format for CSV file</a></label> <!-- will see to you later -->
                    <div class="col-md-12">
                      <input type="file" class="form-control form-control-line" name="file">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-success">Upload</button>
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
  <!-- /#page-wrapper -->
  @endsection
