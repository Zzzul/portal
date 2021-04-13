@extends('layouts.app')
@section('title', 'Check payment status')
@section('content')
<div class="container py-3">
    <div class="row justify-content-md-center">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Check payment status</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            @if (session()->has('error'))
            <div class="alert alert-danger show fade">
                <div class="alert-body">
                    <h5 class="font-weight-bold">{{ session()->get('error') }}</h5>
                </div>
            </div>
            @endif

            {{-- paymnent_status success --}}
            @if (!$event->audiences->isEmpty() && $event['audiences']['0']['pivot']->payment_status == 1)
            <div class="alert alert-success show fade">
                <div class="alert-body">
                    <h5>Payment status:
                        <span class="font-weight-bold">
                            Successfull
                        </span>
                    </h5>
                </div>
            </div>
            @endif

            {{-- paymnent_status pending --}}
            @if (!$event->audiences->isEmpty() && $event['audiences']['0']['pivot']->payment_status == 0)
            <div class="alert alert-danger show fade">
                <div class="alert-body">
                    <h5>Payment status:
                        <span class="font-weight-bold">
                            Pending
                        </span>
                    </h5>
                </div>
            </div>
            @endif

            {{-- if invalid code --}}
            @if (!!$event->audiences->isEmpty() && request()->get('transaction_code'))
            <div class="alert alert-danger show fade">
                <div class="alert-body">
                    <h5 class="font-weight-bold">Invalid transaction code.</h5>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('event.check-payment-status') }}" method="get">
                        <div class="form-group">
                            <label for="transaction-code">Transaction Code</label>
                            <input type="text" class="form-control @error('transaction_code')is-invalid @enderror"
                                placeholder="Transaction Code" id="transaction-code" name="transaction_code"
                                value="{{ request()->get('transaction_code') }}" autofocus />
                            @error('transaction_code') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Check
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
