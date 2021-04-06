@extends('layouts.app')
@section('title', 'Confirm Password')
@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Confirm Password</li>
            </ol>
        </div>

        <div class="col-md-6 mt-2">
            <p>{{ __('Please confirm your password before continuing.') }}</p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-group">
                    <label for="password" class="mb-0">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Confirm Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
