@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
            </ol>
        </div>

        {{-- alert --}}
        @if (session()->has('success'))
        <div class="col-md-12 mt-2">
            <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session()->get('success') }}
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="col-md-12 mt-2">
            <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session()->get('error') }}
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-12">
            <h4>All Events</h4>
        </div>

        @forelse ($events as $event)
        <div class="col-md-4 mt-2">
            <div class="card mb-2">
                {{-- <img src="..." class="card-img-top" alt="Event thumbnail"> --}}
                <div class="card-body">
                    <h5 class="card-title">{{ $event->title }}</h5>
                    {{ Str::limit($event->description, 100) }}

                    <p class="card-text mb-1 mt-2">
                        Category: {{ $event->category->name }}
                    </p>

                    <p class="card-text mb-1">
                        Organizer: {{ $event->organizer->name }}
                    </p>

                    <p class="card-text mb-1">
                        Price: Rp. {{ number_format($event->price, 0,',','.') }}
                    </p>

                    <p class="card-text mb-2 mt-1">
                        Start: {{ date('d F Y', strtotime($event->start_time)) }} -
                        {{ date('d F Y', strtotime($event->finish_time)) }}
                    </p>

                    @if ($event->organizer->id == auth()->id())
                    <button class="btn btn-primary btn-sm px-2 py-2" style="position: absolute;top:0;right:0;">
                        Your Event
                    </button>
                    @else
                    @php
                    $registered = ''
                    @endphp
                    @foreach ($event->audiences as $audience)
                    {{-- jika user sudah terdaftar pada event--}}
                    @if ($audience['pivot']->user_id == auth()->id())
                    <div class="bg-info p-2 rounded" style="position: absolute;top:0;right:0;">
                        <i class="fas fa-check"></i>
                    </div>
                    @php
                    // get audience user_id
                    $registered = $audience['pivot']->user_id
                    @endphp
                    @endif
                    {{-- end of $audience['pivot']->user_id == auth()->id() --}}
                    @endforeach
                    @endif

                    @guest
                    <a href="event/register/{{ $event->slug }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in"></i>
                        Register
                    </a>
                    @endguest

                    @if ($registered != auth()->id())
                    <a href="event/register/{{ $event->slug }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in"></i>
                        Register
                    </a>
                    @endif

                    <a href="event/detail/{{ $event->slug }}" class="btn btn-success btn-block">
                        <i class="fas fa-eye"></i>
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <p>No event found.</p>
        @endforelse
    </div>
</div>
@endsection
