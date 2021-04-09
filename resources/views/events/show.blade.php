@extends('layouts.app')
@section('title', 'Detail of Event - '. $event->title)
@section('content')
<div class="container py-3">
    <div class="row">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Detail of Event</li>
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

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" placeholder="Event title" id="title" name="title"
                            disabled value="{{ $event->title }}" />
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" placeholder="Event category" id="category"
                            name="category" disabled value="{{ $event->category->name }}" />
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start-time">Start time</label>
                            <input type="datetime-local" class="form-control pl-2 pr-0"
                                value="{{ date('Y-m-d\TH:i', strtotime($event->start_time))  }}" id="start-time"
                                name="start_time" disabled />
                        </div>

                        <div class="col-md-6">
                            <label for="finish-time">Finish time</label>
                            <input type="datetime-local" class="form-control pl-2 pr-0"
                                value="{{ date('Y-m-d\TH:i', strtotime($event->finish_time))  }}" id="finish-time"
                                name="finish_time" disabled />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" placeholder="Price" min="0" id="price" disabled
                                name="price" value="{{ $event->price }}" />
                        </div>
                        <div class="col-md-6">
                            <label for="max-audience">Max Audience</label>
                            <input type="number" class="form-control" min="1" value="{{$event->max_audience }}" disabled
                                placeholder="Max Audience" id="max-audience" name="max_audience" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <textarea class="form-control" placeholder="Location" id="location" disabled
                            name="location">{{ $event->location }}</textarea>
                    </div>

                    <div class="form-group">
                        <Label>Performers</Label>
                        <ul>
                            @foreach ($event->performers as $performer)
                            <li>{{ $performer->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                {{-- end of card-body --}}
            </div>
            {{-- end of card --}}
        </div>
        {{-- end of col --}}

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h5>List of all audiences</h5>
                    <table class="table table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($event->audiences as $index => $audience)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $audience['pivot']->transaction_code }}</td>
                                <td>{{ $audience->name }}</td>
                                <td>{{ $audience['pivot']->payment_status == 0 ? 'Pending' : 'Success' }}</td>
                                <td>
                                    @if ($audience['pivot']->payment_status == 0)
                                    <a href="{{ route('event.update-payment-status', $audience['pivot']->transaction_code) }}"
                                        data-toggle="tooltip" data-placement="top" title="Set payment as successful">
                                        <i class="fas fa-check text-success"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('event.update-payment-status', $audience['pivot']->transaction_code) }}"
                                        data-toggle="tooltip" data-placement="top" title="Set payment as pending">
                                        <i class="fas fa-times text-danger"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <li>there are no registered audiences.</li>
                            @endforelse
                        </tbody>
                    </table>
                    <p class="mb-2">Total registered audiences : <span
                            class="font-weight-bold">{{ count($event->audiences) }}</span>
                    </p>
                    <p class="mb-1">
                        <i class="fas fa-check text-success"></i> :
                        Set payment as successful
                    </p>
                    <p>
                        <i class="fas fa-times text-danger"></i> :
                        Set payment as pending
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- end of row --}}
</div>
{{-- end of container --}}
@endsection
