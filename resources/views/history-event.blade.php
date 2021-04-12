@extends('layouts.app')
@section('title', 'History Event')
@section('content')
<div class="container py-3">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">History Event</li>
            </ol>
        </div>

        <div class="col-md-12">
            <h4>Your History Events ({{ count($events) }})</h4>
        </div>

        @forelse ($events as $event)
        <div class="col-md-4 mt-2">
            <div class="card mb-2">
                <img src="{{ asset('storage/images/thumbnail/'. $event->thumbnail) }}" alt="{{ $event->thumbnail }}"
                    class="card-img-top" alt="Event thumbnail">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $event->title }}
                        <hr class="m-1 p-1">
                        <span>
                            @foreach ($event->history as $item)
                            {{ $item['pivot']->transaction_code }}
                            {!! $item['pivot']->payment_status == 1 ? '<i class="fas fa-check text-success ml-2"></i>' :
                            '<i class="fas fa-times text-danger ml-2"></i>' !!}
                            @endforeach
                        </span>
                    </h5>
                    <p class="card-text mb-3">
                        {{ Str::limit($event->description, 200) }}
                    </p>

                    <p class="card-text mb-1">
                        Start: {{ date('d F Y H:i', strtotime($event->start_time)) }} -
                        {{ date('d F Y H:i', strtotime($event->finish_time)) }}
                    </p>

                    <p class="card-text mb-1">
                        Category: {{ $event->category->name }}
                    </p>

                    <p class="card-text mb-1">
                        Organizer: {{ $event->organizer->name }}
                    </p>

                    <p class="card-text mb-1">
                        Price: Rp. {{ number_format($event->price, 0,',','.') }}
                    </p>

                    <p class="card-text mb-1">
                        Performers :
                        <ul class="ml-0 pl-3">
                            @foreach ($event->performers as $performer)
                            <li>{{  Str::ucfirst($performer->name) }} </li>
                            @endforeach
                        </ul>
                    </p>

                    @foreach ($event->history as $item)
                    {!! QrCode::size(310)->generate($item['pivot']->transaction_code) !!}
                    @endforeach

                </div>
            </div>
        </div>
        @empty
        <div class="col-md-4 mt-2">
            <h4>No event found.</h4>
        </div>
        @endforelse
    </div>
</div>
@endsection
