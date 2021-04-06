@extends('layouts.app')
@section('title', 'Edit category - ' . $category->name)
@section('content')
<div class="container py-3">
    <div class="row">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
                    <li class="breadcrumb-item active">Edit category</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('category.update', $category->id) }}" method="post">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                        placeholder="Category Name" id="name" name="name" value="{{ old('title', $category->name) }}" />
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
