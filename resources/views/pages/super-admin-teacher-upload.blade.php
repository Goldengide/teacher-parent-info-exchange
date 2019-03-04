@extends('layouts.super-admin')
@section('content')
  
      <!-- .row -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box p-l-20 p-r-20">
            <h3 class="box-title m-b-0">Upload New Teachers</h3>
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
                <form class="form-material form-horizontal" method="post" action="{{url('super-admin/teacher/upload')}}" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="form-group">
                    <label class="col-md-12">Teachers File<span class="help"> e.g upload a CSV file.</span> 
                      <a href="{{ url('/super-admin/template/teacher.csv') }}"> Download Format for CSV file</a></label> <!-- will see to you later -->
                    <div class="col-md-12">
                      <input type="file" class="form-control form-control-line" name="file">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-lg btn-success">Upload</button>
                      <a href="{{url('/super-admin/teachers')}}" class="btn btn-lg btn-info">Go Back</a>
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
