@extends('layouts.app')
@section('title', 'Create new Event')
@section('content')
<div class="container py-3">
    <div class="row">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="./">Event</a></li>
                    <li class="breadcrumb-item active">Create new Event</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('event.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')

                        {{-- title --}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title')is-invalid @enderror"
                                placeholder="Event title" id="title" name="title" value="{{ old('title') }}" />
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- category --}}
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control @error('category_id')is-invalid @enderror"
                                placeholder="Category" value="{{ old('category_id') }}" id="category"
                                name="category_id">
                                <option value="" selected disabled>--Select category--</option>
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @empty
                                <option value="" disabled>category not found</option>
                                @endforelse
                            </select>
                            @error('category_id') <span class="text-danger">The category field is required.</span>
                            @enderror
                        </div>

                        {{-- start time and finish time --}}
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="start-time">Start time</label>
                                <input type="datetime-local"
                                    class="form-control @error('start_time')is-invalid @enderror"
                                    value="{{ old('start_time') }}" id="start-time" name="start_time" />
                                @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="finish-time">Finish time</label>
                                <input type="datetime-local"
                                    class="form-control @error('finish_time')is-invalid @enderror"
                                    value="{{ old('finish_time') }}" id="finish-time" name="finish_time" />
                                @error('finish_time') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- price and max audience --}}
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="price">Price</label>
                                <input type="number" class="form-control @error('price')is-invalid @enderror"
                                    placeholder="Price" min="0" id="price" name="price" value="{{ old('price') }}" />
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="max-audience">Max Audience</label>
                                <input type="number" class="form-control @error('max_audience')is-invalid @enderror"
                                    min="1" value="{{ old('max_audience') }}" placeholder="Max Audience"
                                    id="max-audience" name="max_audience" />
                                @error('max_audience') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        {{-- description --}}
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description')is-invalid @enderror"
                                placeholder="Description" id="description"
                                name="description">{{ old('description') }}</textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- location --}}
                        <div class="form-group">
                            <label for="location">Location</label>
                            <textarea class="form-control @error('location')is-invalid @enderror" placeholder="Location"
                                id="location" name="location">{{ old('location') }}</textarea>
                            @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        {{-- thumbnail --}}
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label>
                            <input type="file" class="form-control @error('thumbnail')is-invalid @enderror"
                                id="thumbnail" name="thumbnail" />
                            @error('thumbnail') <span class="text-danger">{{ $message }}</span> @enderror
                            <label for="thumbnail">
                                Image: jpg, png, jpeg, svg, max:2MB
                            </label>
                        </div>

                        {{-- Performers --}}
                        <div class="form-group">
                            <Label class="mb-0">Performers</Label>
                            @forelse ($performers as $performer)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="performer_id[]"
                                    id="performer-id-{{ $performer->id }}" value="{{ $performer->id }}">
                                <label class="form-check-label" for="performer-id-{{ $performer->id }}">
                                    {{ $performer->name }}
                                </label>
                            </div>
                            @empty
                            <p class="text-danger">Performers empty/not found.</p>
                            @endforelse

                            @error('performer_id')
                            <span class="text-danger">The performers field is required.</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Save</button>
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
