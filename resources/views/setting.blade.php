@extends('layouts.app')
@section('title', 'Setting')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Setting</li>
                </ol>
            </div>
        </div>

        <div class="col-md-4 mt-2">
            <h5>Profile Information</h5>
        </div>
        <div class="col-md-6 mt-2">
            @if (session('status') == 'profile-information-updated')
            <div class="alert alert-success">
                Profile information updated successfully.
            </div>
            @endif
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('put')
                <div class="form-group mb-3">
                    <label class="mb-0" for="name">{{ __('Name') }}</label>
                    <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ old('name') ?? auth()->user()->name }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="mb-0" for="email">{{ __('E-Mail Address') }}</label>

                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') ?? auth()->user()->email }}" required autocomplete="email"
                        autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Profile') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-12">
            <hr>
        </div>

        <div class="col-md-4 mt-3">
            <h5>Change Password</h>
        </div>
        <div class="col-md-6 mt-3">
            @if (session('status') == 'password-updated')
            <div class="alert alert-success">
                Password updated successfully.
            </div>
            @endif

            <form method="POST" action="{{ route('user-password.update') }}">
                @csrf
                @method('put')

                <div class="form-group mb-3">
                    <label class="mb-0" for="current_password">{{ __('Current Password') }}</label>

                    <input id="current_password" type="password"
                        class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                        name="current_password">

                    @error('current_password', 'updatePassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="mb-0" for="password">{{ __('New Password') }}</label>

                    <input id="password" type="password"
                        class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password"
                        required autocomplete="new-password">

                    @error('password', 'updatePassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label class="mb-0" for="password-confirm">{{ __('Confirm Password') }}</label>

                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                        required autocomplete="new-password">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Password') }}
                    </button>
                </div>
            </form>
        </div>

        <div class="col-md-12 my-2">
            <hr>
        </div>

        <div class="col-md-4 mt-3">
            <h5>Two Factor Authentication</h5>
        </div>
        <div class="col-md-6 mt-3">
            @if (session('status') == 'two-factor-authentication-disabled')
            <div class="alert alert-success" role="alert">
                Two factor Authentication has been disabled.
            </div>
            @endif

            @if (session('status') == 'two-factor-authentication-enabled')
            <div class="alert alert-success" role="alert">
                Two factor Authentication has been enabled.
            </div>
            @endif

            <form method="post" action="/user/two-factor-authentication">
                @csrf
                {{-- if user activate two factor authentication --}}
                @if (auth()->user()->two_factor_secret)
                @method('delete')
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-2">
                        <p>
                            Scan the following QR Code into your authentication
                            applications.
                        </p>
                        {!! auth()->user()->twoFactorQrcodeSvg() !!}
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <p>Save these Recovery Codes in a secure location.</p>
                        <ul>
                            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                            <li>{{ $code }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-8">
                        <button class="btn btn-danger mt-3" type="submit">Disable Two Factor
                            Authentication</button>

                        @else
                        <button class="btn btn-primary" type="submit">Enable Two Factor
                            Authentication</button>
                        @endif
                    </div>
                </div>
            </form>

            {{-- generate recovery codes --}}
            @if ((auth()->user()->two_factor_secret))
            <form method="POST" action="/user/two-factor-recovery-codes">
                @csrf
                <button class="btn btn-primary mt-3" type="submit">
                    Regenerate Recovery Codes
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
