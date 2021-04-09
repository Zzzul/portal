@extends('layouts.app')
@section('title', 'Edit Event - '. $event->title)
@section('content')
<div class="container py-3">
    <div class="row">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active">Edit Event</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('event.update', $event->id) }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title')is-invalid @enderror"
                                placeholder="Event title" id="title" name="title"
                                value="{{ old('title', $event->title) }}" />
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category_id')is-invalid @enderror"
                                placeholder="Category" value="{{ old('category_id', $event->category_id) }}"
                                id="category" name="category_id">
                                <option value="" selected disabled>--Select category--</option>
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $event->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @empty
                                <option value="" disabled>category not found</option>
                                @endforelse
                            </select>
                            @error('category_id') <span class="text-danger">The category field is required.</span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="start-time">Start time</label>
                                <input type="datetime-local"
                                    class="form-control @error('start_time')is-invalid @enderror"
                                    value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($event->start_time)) ) }}"
                                    id="start-time" name="start_time" />
                                @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="finish-time">Finish time</label>
                                <input type="datetime-local"
                                    class="form-control @error('finish_time')is-invalid @enderror"
                                    value="{{ old('finish_time', date('Y-m-d\TH:i', strtotime($event->finish_time)) ) }}"
                                    id="finish-time" name="finish_time" />
                                @error('finish_time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="price">Price</label>
                                <input type="number" class="form-control @error('price')is-invalid @enderror"
                                    placeholder="Price" min="0" id="price" name="price"
                                    value="{{ old('price', $event->price) }}" />
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="max-audience">Max Audience</label>
                                <input type="number" class="form-control @error('max_audience')is-invalid @enderror"
                                    min="1" value="{{ old('max_audience', $event->max_audience) }}"
                                    placeholder="Max Audience" id="max-audience" name="max_audience" />
                                @error('max_audience') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <textarea class="form-control @error('location')is-invalid @enderror" placeholder="Location"
                                id="location" name="location">{{ old('location', $event->location) }}</textarea>
                            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- description --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description')is-invalid @enderror"
                                placeholder="Description" id="description"
                                name="description">{{ old('description', $event->description) }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="form-group @error('performer_id')text-danger @enderror">
                            <Label>Performers</Label>
                            @foreach ($event->performers as $performer)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="performer_id[]"
                                    id="performer-id-{{ $performer->id }}" value="{{ $performer->id }}" checked>
                                <label class="form-check-label" for="performer-id-{{ $performer->id }}">
                                    {{ $performer->name }}
                                </label>
                            </div>
                            @endforeach

                            @foreach ($not_event_performers as $not_event_performer)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="performer_id[]"
                                    id="performer-id-{{ $not_event_performer->id }}"
                                    value="{{ $not_event_performer->id }}">
                                <label class="form-check-label" for="performer-id-{{ $not_event_performer->id }}">
                                    {{ $not_event_performer->name }}
                                </label>
                            </div>
                            @endforeach

                            @error('performer_id') <span class="text-danger">The performers field is required.</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Update
                        </button>
                    </form>
                </div>
                {{-- end of card-body --}}
            </div>
            {{-- end of card --}}
        </div>
        {{-- end of col --}}
    </div>
    {{-- end of row --}}
</div>
{{-- end of container --}}
@endsection
