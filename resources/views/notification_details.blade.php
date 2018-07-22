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

                        <a href="{{ route('home') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;">Request For My Blood Group</a></p>
                        <a href="{{ route('request_in_my_area') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:51px;padding-right:51px">Request In My Area</a></p>
                        <a href="{{ route('show_history') }}" class="btn btn-success" style="text-align:center;font-size:18px;padding-top:30px;padding-bottom:30px;padding-left:102px;padding-right:102px">History</a>  </li></p>

                      </div>

                      <div class="col-sm-9">
                        <div class="row">


                          <div class="col-sm-12">
                            <div class="card-body">
                              <h5 class="card-header" style="background:#ccffcc;padding-bottom:30px">
                              <div style="float:left;">
                                @foreach($users as $data_2)
                                  @if($notf->action == 'Accepted' || $notf->action == 'Suggested')
                                      @if($data_2->id == $notf->user_whom)
                                          <img src="/uploads/avatars/{{ $data_2->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                                          {{  $data_2->name }}
                                          @break
                                      @endif

                                  @else
                                    @if($data_2->id == $notf->auth_user)
                                        <img src="/uploads/avatars/{{ $data_2->avatar }}" style="width:30px;height:30px;top:10px;left:10px;border-radius:50%;float:left;align:left;margin-bottom:20px;margin-right:10px;" >
                                        {{  $data_2->name }}
                                        @break
                                    @endif

                                  @endif
                                @endforeach
                              </div>
                              <div style="float:right;">
                                {{  $req->updated_at }}
                              </div>
                              </h5>
                              <p class="card-body" style="background:#f2f2f2;padding-bottom:30px;">
                              Requested Blood: {{ $req->blood_group }} for {{ $req->urgency }}</br>
                              Area : {{ $req->area }}</br>
                              Place of Donation : {{ $req->place_of_donation }}</br>
                              Urgency : For {{ $req->urgency }} within {{ $req->within }}</br>
                              Contact To: {{ $req->contact }}</br>

                              @if($notf->action != 'Accepted' && $notf->action != 'Suggested')
                              <a href="{{ route('accept_verify_for_notification',["id" => $req->id , "id_nt" => $notf->id, "action_id" => $notf->action_id, "auth_user" => $notf->auth_user]) }}" class="btn btn-info" style="margin:5px;float:right;">Accept</a>
                              <a href="{{ route('suggest_form_for_notification',["id" => $req->id , "id_nt" => $notf->id ]) }}" class="btn btn-info" style="margin:5px;float:right;">Suggest</a>
                              @endif
                              <a href="{{ route('show_accept_list',$req->id) }}" class="btn btn-secondary" style="margin:5px;float:left;">Accepted ({{ $req->req_info }})</a>
                              <a href="{{ route('show_suggest_list',$req->id) }}" class="btn btn-secondary" style="margin:5px;float:left;">Suggestion ({{ $req->status_info }})</a>

                              </p>

                            </div>
                          </div>

                        </div>
                      </div>

                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
