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
                @if ($event->thumbnail)
                <img src="{{ asset('storage/images/thumbnail/'. $event->thumbnail) }}" alt="{{ $event->thumbnail }}"
                    class="img-fluid rounded card-img-top">
                @endif

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
                    <div class="bg-primary p-2 rounded" style="position: absolute;top:0;right:0;">
                        <i class="fas fa-crown text-light"></i>
                    </div>
                    @php $registered = $event->organizer->id @endphp
                    @else

                    @php $registered = '' @endphp

                    @foreach ($event->audiences as $audience)
                    {{-- jika user sudah terdaftar pada event--}}
                    @if ($audience['pivot']->user_id == auth()->id())
                    <div class="bg-primary p-2 rounded" style="position: absolute;top:0;right:0;">
                        <i class="fas fa-check text-light"></i>
                    </div>
                    @php $registered = $audience['pivot']->user_id @endphp
                    @endif
                    {{-- end of $audience['pivot']->user_id == auth()->id() --}}
                    @endforeach
                    @endif

                    @guest
                    <a href="{{ route('event.register', $event->slug) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i>
                        Register
                    </a>
                    @endguest

                    @if ($registered != auth()->id())
                    <a href="{{ route('event.register', $event->slug) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i>
                        Register
                    </a>
                    @endif

                    <a href="{{ route('event.detail', $event->slug) }}" class="btn btn-success btn-block">
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
