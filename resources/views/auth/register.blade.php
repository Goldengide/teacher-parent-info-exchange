@extends('layouts.auth')
@section('content')
<section id="wrapper" class="login-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
      @if(count($errors) > 0)

        <ul class="alert alert-danger">

            @foreach($errors->all() as $error)

               <li>{{$error}}</li>

            @endforeach
        </ul>

      @endif

      @if (session('message'))
        <p class="{{session('style')}}" style="color: white">{{ session('message')}}</p>
      @endif
      <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <a href="javascript:void(0)" class="text-center db"><img src="{{URL::asset("plugins/images/eliteadmin-logo-dark.png")}}" alt="Home" /><br/><img src="{{URL::asset("plugins/images/eliteadmin-text-dark.png") }}" alt="Home" /></a> 
        <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your account and enjoy</small> 
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="firstname" placeholder="Firstname">
          </div>
        </div>
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="lastname" required="" placeholder="Lastname">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="email" required="" placeholder="Email">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="phone" required="" placeholder="Phone">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="password" name="password" required="" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="password" name="password_confirmation" required="" placeholder="Confirm Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary p-t-0">
              <input id="checkbox-signup" type="checkbox">
              <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
            </div>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Sign Up</button>
          </div>
        </div>
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Already have an account? <a href="login2.html" class="text-primary m-l-5"><b>Sign In</b></a></p>
          </div>
        </div>
      </form>
    </div>
    
  </div>
</section>
@endsection
