@extends('layouts.teachers')
@section('content')
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">{{ $parent->fullname }} profile</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li><a href="{{ url('/super-admin/dashboard')}}">Dashboard</a></li>
            <li><a href="{{ url('/super-admin/students  ')}}">Back to the Student's List</a></li>
            <li class="active"> {{ $parent->fullname }} </li>
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
                <dt style="text-align: left; white-space: normal;">Parent Name:</dt> <dd>{{ $parent->fullname }}</dd>  <br><br>

                <dt style="text-align: left; white-space: normal;">Phone: </dt> <dd>{{ $parent->phone }} <a href="#send-mesage" class="showSendMessage"><i class="icon icon-envelope"></i></a> </dd> <br><br>

                <dt style="text-align: left; white-space: normal;">Email: </dt> <dd>{{ $parent->email }}</dd> <br></br>


              </dl>
            </div>
          </div>
        </div>
        @if($countChildren > 0)
          <div class="col-sm-12 col-md-5">
            <div class="white-box p-l-20 p-r-20">
              <div class="row"><?php $sn = 0; ?>
                <dl class="dl-horizontal">

                  <dt style="text-align: left; white-space: normal;">No of Children In School </dt> <dd>{{ $countChildren }}</dd> <br>

                  @foreach($students as $student)
                    <?php $sn++; ?>
                    <dt style="text-align: left; white-space: normal;">{{$sn}}</dt> <dd><a href="{{ url('/teacher/students/profile/'. $student->id) }}">See {{ $student->student_name }} Profile</a></dd> <br></br>

                    

                  @endforeach

                </dl>
              </div>
            </div>
          </div>

        @endif
      </div>
      <!-- /.row -->

      <div class="row" id="sendMesage">
        <div class="col-sm-12 col-md-12">
          <div class="white-box p-l-20 p-r-20">
            <div class="row">
              <form class="form-material form-horizontal" method="post" action="{{url('parent/message/send')}}">
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{$parent->id}}">
                <input type="hidden" name="to" value="{{$parent->phone}}">
                <input type="hidden" name="cc" value="08174007780">
                <div class="form-group">
                  <label class="col-md-2">To</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control form-control-line" name="name" value="{{$parent->fullname}}" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <!-- <label class="col-md-2">Message</label> -->
                  <div class="col-md-12">
                    <textarea style="width: 100%; border-radius: 0.3em;">Message Here...</textarea>
                  </div>
                </div>
                      
                <div class="form-group">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-md btn-info">Send Message</button>
                  </div>
                </div>
              </form>
              
            </div>
            
          </div>
        </div>
      </div>
      
      
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->

  @endsection 
  @section('other-scripts')
    <script>
      $(document).ready(function(){
        $('#sendMesage').hide();
        $('.showSendMessage').mousedown(function() {
          $('#sendMesage').toggle();
        })
      });
      
    </script>
  @endsection