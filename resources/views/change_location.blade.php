@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header">
                      Present Location : {{ Auth::user()->location }}
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
                          <form method="POST" action="{{ route('change_location_done') }}">
                              @csrf

                              <div class="form-group row">
                                  <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Select Current` Location') }}</label>

                                  <div class="col-md-6">
                                    <select id="location" type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" value="{{ old('location') }}" required autofocus>
                                      @foreach($div as $division)
                                      <option value="{{ $division->name }}" @if(Auth::user()->location == $division->name) selected @endif >{{ $division->name }}</option>
                                      @endforeach

                                    </select>

                                      @if ($errors->has('location'))
                                          <span class="invalid-feedback">
                                              <strong>{{ $errors->first('location') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group row mb-0">
                                  <div class="col-md-6 offset-md-4">
                                      <button type="submit" class="btn btn-primary">
                                          {{ __('Change') }}
                                      </button>
                                  </div>
                              </div>
                          </form>
                        </div>


                        </div>
                      </div>

                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
