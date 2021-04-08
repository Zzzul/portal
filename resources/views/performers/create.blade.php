@extends('layouts.app')
@section('title', 'Create new performer')
@section('content')
<div class="container py-3">
    <div class="row justify-content-md-center">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="./">Performer</a></li>
                    <li class="breadcrumb-item active">Create new Performer</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('performer.store') }}" method="post">
                        @csrf
                        @method('post')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name')is-invalid @enderror"
                                placeholder="Name" value="{{ old('name') }}" id="name" name="name" />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
