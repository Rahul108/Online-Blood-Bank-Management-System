@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Present Location : {{ Auth::user()->location }}
                    <a href="{{ URL::route('change_location') }}" class="btn btn-success" >Change Current Location</a>
                   <a href="{{ URL::route('request_blood_show') }}" class="btn btn-success" style="float:right">Request Blood</a>
                 </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">

                      <div class="col-sm-3" style="position:relative">

                        <a href="{{ route('home') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;background:#4f55c1">Request For My Blood Group</a></p>
                        <a href="{{ route('request_in_my_area') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:51px;padding-right:51px">Request In My Area</a></p>
                        <a href="{{ route('show_history') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:102px;padding-right:102px">History</a>  </li></p>

                      </div>

                      <div class="col-sm-9" style="position:static;">
                        <div class="row">


                          @foreach($data_show as $data)
                          <div class="col-sm-12">
                            <div class="card-body">
                              <h5 class="card-header" style="background:#ccffcc;padding-bottom:30px">
                              <img src="/uploads/avatars/{{ Auth::user()->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                              <div style="float:left;">{{  Auth::user()->name }}</div>
                              <div style="float:right;">{{  $data->updated_at }}</div>
                              </h5>
                              <p class="card-body" style="background:#f2f2f2;padding-bottom:30px;">
                              Requested Blood: {{ $data->blood_group }}</br>
                              Area : {{ $data->area }}</br>
                              Place of Donation : {{ $data->place_of_donation }}</br>
                              Urgency : For {{ $data->urgency }} within {{ $data->within }}</br>
                              Contact To: {{ $data->contact }}</br>
                              <a href="{{ route('show_accept_list',$data->id) }}" class="btn btn-secondary" style="margin:5px;float:left;">Accepted ({{ $data->req_info }})</a>
                              <a href="{{ route('show_suggest_list',$data->id) }}" class="btn btn-secondary" style="margin:5px;float:left;">Suggestion ({{ $data->status_info }})</a>

                              </p>

                            </div>
                          </div>
                          @endforeach

                        </div>
                      </div>

                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
