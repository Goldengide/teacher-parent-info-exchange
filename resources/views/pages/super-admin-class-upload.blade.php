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
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0">Upload Classes</h3>
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
                <form class="form-material form-horizontal" method="post" action="{{url('super-admin/classes/upload')}}" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label class="col-md-12">Classes File<span class="help"> e.g upload a CSV file.</span> 
                      <a href="{{ url('/super-admin/template/class.csv')}}"> Download Format for CSV file</a></label> <!-- will see to you later -->
                    <div class="col-md-12">
                      <input type="file" class="form-control form-control-line" name="file">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-success">Upload</button>
                      <a href="{{url('/super-admin/classes')}}" class="btn btn-lg btn-outline btn-default">Go Back</a>
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
