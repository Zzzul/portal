@extends('layouts.app')
@section('title', 'Register')
@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Register</li>
            </ol>
        </div>

        <div class="col-md-6 mt-2">
            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <div class="form-group mb-3">
                    <label class="pb-0 mb-0" for="name">{{ __('Name') }}</label>

                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="pb-0 mb-0" for="email">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="pb-0 mb-0" for="password">{{ __('Password') }}</label>

                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="pb-0 mb-0" for="password-confirm">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">
                </div>

                <div class="form-group mb-3">
                    <label class="pb-0 mb-0" for="role">{{ __('Register As') }}</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="" selected disabled>--Select Role--</option>
                        <option value="2">Organizer</option>
                        <option value="3">Audience</option>
                    </select>
                    @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3 mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
