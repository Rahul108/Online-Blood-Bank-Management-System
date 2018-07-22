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
                    <div class="row justify-content-center">

                      <div class="col-sm-3">

                        <a href="{{ route('home') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px">Request For My Blood Group</a></p>
                        <a href="{{ route('request_in_my_area') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:51px;padding-right:51px">Request In My Area</a></p>
                        <a href="{{ route('show_history') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:102px;padding-right:102px;background:#4f55c1">History</a>  </li></p>

                      </div>


                          <div class="col-sm-9">
                            <div class="row">

                          @foreach($history as $his)
                          @if($his->user_oth == Auth::user()->mobile_no)
                          <div class="col-sm-12">
                            <div class="card-body">
                              <h5 class="card-header" style="background:#ccffcc;padding-bottom:30px">
                              <div style="float:left;">
                                @foreach($data_show_2 as $data_2)
                                    @if($data_2->mobile_no == $his->user_oth)
                                        <img src="/uploads/avatars/{{ $data_2->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                                        {{  $data_2->name }}
                                        @break
                                    @endif
                                @endforeach
                              </div>
                              <div style="float:right;">{{  $his->updated_at }}</div>
                              </h5>
                              <p class="card-body" style="background:#f2f2f2;padding-bottom:30px;">
                              @if($his->user_to_whom == 'all')
                              You have Requested for Blood on {{ $his->updated_at }}
                              @elseif($his->action == 'Accepted')
                              You have accepted
                              @foreach($data_show_2 as $data_2)
                              @if($his->user_to_whom == $data_2->mobile_no)
                              {{ $data_2->name }}'s
                              @endif
                              @endforeach
                              Request of date : {{ $his->updated_at }}
                              @else
                              You have suggested
                              @foreach($data_show_2 as $data_2)
                              @if($his->user_to_whom == $data_2->mobile_no)
                              {{ $data_2->name }}
                              @endif
                              @endforeach
                              on his request of {{ $his->updated_at }}
                              @endif
                              </p>
                            </div>
                          </div>
                          @endif

                          @if($his->user_to_whom == Auth::user()->mobile_no)
                              <div class="col-sm-12">
                                <div class="card-body">
                                  <h5 class="card-header" style="background:#ccffcc;padding-bottom:30px">
                                  <div style="float:left;">
                                    @foreach($data_show_2 as $data_2)
                                        @if($data_2->mobile_no == $his->user_oth)
                                            <img src="/uploads/avatars/{{ $data_2->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                                            {{  $data_2->name }}
                                            @break
                                        @endif
                                    @endforeach
                                  </div>
                                  <div style="float:right;">{{  $his->updated_at }}</div>
                                  </h5>
                                  <p class="card-body" style="background:#f2f2f2;padding-bottom:30px;">
                                    @foreach($user as $dd)
                                      @if($his->user_oth == $dd->mobile_no)
                                        {{ $dd->name }} has @if($his->action == 'Accepted') {{ $his->action }} your Blood Request of {{ $his->updated_at }} !! @else {{ $his->action }} on your Blood Request of {{ $his->updated_at }} !! @endif
                                      @endif
                                    @endforeach
                                  </p>
                                </div>
                              </div>
                              @endif
                          @endforeach

                        </div>
                      </div>

                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
