@extends('layouts.app')
@section('title', 'Two Factor Challenge')
@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Two Factor Challenge</li>
            </ol>
        </div>

        <div class="col-md-6 mt-2">
            <p class="">{{ __('Please enter your atuhentication code to login.') }}</p>

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="form-group">
                    <label for="code" class="mb-0">{{ __('Code') }}</label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code">

                    @error('code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                <p class="mt-4">{{ __('Or you can enter one of your recovery codes.') }}</p>
                <div class="form-group">
                    <label for="recovery_code" class="mb-0">{{ __('Recovery Code') }}</label>
                    <input id="recovery_code" type="text"
                        class="form-control @error('recovery_code') is-invalid @enderror" name="recovery_code">

                    @error('recovery_code')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </form>
            {{-- end of card-body --}}
        </div>
        {{-- end of col --}}
    </div>
    {{-- end of row --}}
</div>
{{-- end of container --}}
@endsection
