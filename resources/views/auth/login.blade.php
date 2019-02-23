@extends('layouts.auth')
@section('content')
<section id="wrapper" class="login-register">
  <div class="login-box">
    <div class="white-box">
      @if(count($errors) > 0)

        <ul class="alert alert-danger">

            @foreach($errors->all() as $error)

               <li>{{$error}}</li>

            @endforeach
        </ul>

      @endif

      @if (session('message'))
        <p class="alert-{{session('style')}}" style="color: white">{{ session('message')}}</p>
      @endif
      <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ url('login') }}">
        {{ csrf_field() }}
        <h3 class="box-title m-b-20">Sign In</h3>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" name="email" type="text" required="" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" name="password" type="password" required="" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <input id="checkbox-signup" type="checkbox">
              <label for="checkbox-signup"> Remember me </label>
            </div>
            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
          </div>
        </div>
        
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Don't have an account? <a href="register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
          </div>
        </div>
      </form>
      <form class="form-horizontal" id="recoverform" action="index.html">
        <div class="form-group ">
          <div class="col-xs-12">
            <h3>Recover Password</h3>
            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" placeholder="Email">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection