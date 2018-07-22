@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 call-md-offset-1">
            <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px;height:150px;float:left;border-radius:50%; margin-right:50px" >
            <h2>{{ $user->name }}'s profile </h2>
            <form enctype="multipart/form-data" action="/profile" method="POST" >
              <label> Upload Profile Image</label></p>
              <input type="file" name="avatar">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="submit" class="pull-right btn btn-sm btn-primary">
            </form>
        </div>


      </p></p></p>
      <div class="row" style="padding-top:20px">

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4>Name: {{  Auth::user()->name }}</h4></p></div>

      <div class="col-sm-6" style="background-color:lavender;"><h4><h4>Gender: {{  Auth::user()->gender }}</h4></p></div>

      <div class="col-sm-6" style="background-color:lavender;"><h4><h4>Birth Date: {{  Auth::user()->birth_date }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4><h4>Height: {{  Auth::user()->height }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4><h4>Weight: {{  Auth::user()->weight }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavender;"><h4><h4>Blood Groupt: {{  Auth::user()->blood_group }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavender;"><h4><h4>Mobile No: {{  Auth::user()->mobile_no }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4><h4>Email: {{  Auth::user()->email }}</h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4><h4>Facebook:
        <a href="{{  Auth::user()->facebook_id }}">
          @if(Auth::user()->facebook_id != "NULL")
          {{  Auth::user()->facebook_id }}
          @endif
        </a>
      </h4></p></h4></p></div>

          <div class="col-sm-6" style="background-color:lavender;"><h4><h4><h4>Twitter: <a href="{{  Auth::user()->twitter_id }}">
            @if(Auth::user()->twitter_id != "NULL")
            {{  Auth::user()->twitter_id }}
            @endif
          </a>
        </h4></p></h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavender;"><h4><h4><h4>Present Address: {{  Auth::user()->present_address }}</h4></p></h4></p></h4></p></div>

      <div class="col-sm-6" style="background-color:lavenderblush;"><h4><h4><h4>Permanent Address: {{  Auth::user()->permanent_address }}</h4></p></h4></p></h4></p></div>

      <div class="col-sm-12" style="padding-left:500px;padding-top:20px;position:center" ><a href="{{ URL::route('user_edit') }}" class="btn btn-success" style="padding-top:10px;width:200px;height:20ox"> Edit Profile </a> </div>

    </div>





    </div>



    </div>

@endsection
