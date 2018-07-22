@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Request Blood') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('request_blood_submt') }}">
                        @csrf


                        <div class="form-group row">
                            <label for="blood_group_req" class="col-md-4 col-form-label text-md-right">{{ __('Blood Group') }}</label>

                            <div class="col-md-6">
                                <select id="blood_group_req" type="text" class="form-control{{ $errors->has('blood_group_req') ? ' is-invalid' : '' }}" name="blood_group_req" value="{{ old('blood_group_req') }}" required autofocus>
                                  <option value="A">A</option>
                                  <option value="A-">A-</option>
                                  <option value="A+">A+</option>
                                  <option value="B">B</option>
                                  <option value="B-">B-</option>
                                  <option value="B+">B+</option>
                                  <option value="AB-">AB-</option>
                                  <option value="AB+">AB+</option>
                                  <option value="A">O-</option>
                                  <option value="A">O+</option>
                                </select>

                                @if ($errors->has('blood_group_req'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('blood_group_req') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="location_to_find" class="col-md-4 col-form-label text-md-right">{{ __('Select Current` Location') }}</label>

                            <div class="col-md-6">
                              <select id="location_to_find" type="text" class="form-control{{ $errors->has('location_to_find') ? ' is-invalid' : '' }}" name="location_to_find" value="{{ old('location_to_find') }}" required autofocus>
                                @foreach($div as $division)
                                <option value="{{ $division->name }}" @if(Auth::user()->location == $division->name) selected @endif >{{ $division->name }}</option>
                                @endforeach

                              </select>

                                @if ($errors->has('location_to_find'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('location_to_find') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="reason" class="col-md-4 col-form-label text-md-right">{{ __('Urgency') }}</label>

                              <div class="col-md-2">
                            For:<select id="reason" type="text" class="form-control{{ $errors->has('reason') ? ' is-invalid' : '' }}" name="reason" value="{{ old('reason') }}" required autofocus>
                              <option value="self">Self</option>
                              <option value="other">Other</option>
                            </select>
                              </div>
                              <div class="col-md-4">
                            Within: <input id="reason_dateline" placeholder="Within" type="date" class="form-control{{ $errors->has('reason_dateline') ? ' is-invalid' : '' }}" name="reason_dateline" value="{{ Auth::user()->reason_dateline }}" required autofocus>
                                @if ($errors->has('reason'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('reason') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="mobile_no" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No') }}</label>
                            <div class="col-md-6">
                                <input id="mobile_no" placeholder="In which users will contact" type="tel" class="form-control{{ $errors->has('mobile_no') ? ' is-invalid' : '' }}" name="mobile_no" required autofocus>
                                @if ($errors->has('mobile_no'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('mobile_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="donation_place" class="col-md-4 col-form-label text-md-right">{{ __('Place of Donation') }}</label>
                            <div class="col-md-6">
                                <input id="donation_place" placeholder="Specific location in your area" type="text" class="form-control{{ $errors->has('donation_place') ? ' is-invalid' : '' }}" name="donation_place" value="{{ old('donation_place') }}" required autofocus>
                                @if ($errors->has('donation_place'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('donation_place') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Request') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
