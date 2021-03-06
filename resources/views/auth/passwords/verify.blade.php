@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('verify.for.pass.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="verification_number" class="col-md-4 col-form-label text-md-right">{{ __('Verification Number') }}</label>

                            <div class="col-md-6">
                                <input id="verification_number" type="text" class="form-control{{ $errors->has('verification_number') ? ' is-invalid' : '' }}" name="verification_number" value="{{ old('verification_number') }}" required autofocus>

                                @if ($errors->has('verification_number'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('verification_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verify') }}
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
