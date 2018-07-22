@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard <a href="{{ URL::route('request_blood_show') }}" class="btn btn-success" style="float:right">Request Blood</a> </div>

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
                        <a href="{{ route('show_history') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:102px;padding-right:102px">History</a>  </li></p>

                      </div>


                          <div class="col-sm-9">
                            <div class="row">


                          @foreach($data_sugg as $a)
                          <div class="col-sm-12">
                            <div class="card-body">
                              <h5 class="card-header" style="background:#ccffcc;padding-bottom:30px">
                                @foreach($data_user as $u)
                                  @if($a->suggested_by == $u->mobile_no)
                                    <img src="/uploads/avatars/{{ $u->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                                    {{ $u->name }}
                                  @endif
                                @endforeach
                              </h5>
                              <p class="card-body" style="background:#f2f2f2;padding-bottom:30px;">
                                For {{ $data_req->blood_group  }} blood contact with {{ $a->suggested_name }}</br>
                                Mobile No: {{ $a -> suggested_mobile_no }}</br>
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
