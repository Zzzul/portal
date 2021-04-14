@extends('layouts.app')
@section('title', 'Detail Event - '. $event->title)
@section('content')
<div class="container py-3">
    <div class="row">

        {{-- breadcumb --}}
        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Event</a></li>
                    <li class="breadcrumb-item active">{{ $event->title }}</li>
                </ol>
            </div>
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
            <div class="card pr-2">
                <div class="row">
                    <div class="col-md-5">
                        @if ($event->thumbnail)
                        <img src="{{ asset('storage/images/thumbnail/'. $event->thumbnail) }}"
                            alt="{{ $event->thumbnail }}" class="img-fluid card-img-top">
                        @endif

                        <div class="mt-0">
                            @if ($event->organizer->id == auth()->id())
                            <div class="bg-primary p-2" style="position: absolute;top:0;right:0;">
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
                            <a href="{{ route('event.book', $event->slug) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i>
                                Book
                            </a>
                            @endguest

                            @if ($registered != auth()->id())
                            <a href="{{ route('event.book', $event->slug) }}" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt"></i>
                                Book
                            </a>
                            @endif

                            <p class="m-3">
                                Send proof of transfer to email <a
                                    href="mailto:{{ $event->organizer->email }}">{{ $event->organizer->email }}</a>
                                before
                                the event starts.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-7 p-3">
                        <h4> {{ $event->title }}</h4>

                        <p>{{ $event->description }}</p>

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
                            Start: {{ date('d F Y H:i', strtotime($event->start_time)) }} -
                            {{ date('d F Y H:i', strtotime($event->finish_time)) }}
                        </p>

                        <p class="card-text mb-1">
                            Max Audiences: {{ $event->max_audience }}
                        </p>

                        <p class="card-text mb-1">
                            Registered Audiences: {{ count($event->audiences) }}
                        </p>

                        <p class="card-text mb-1">Performers
                            <ul class="ml-0 pl-3">
                                @foreach ($event->performers as $performer)
                                <li>{{  Str::ucfirst($performer->name) }} </li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
            {{-- end of card --}}
        </div>
    </div>
</div>
@endsection
