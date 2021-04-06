@extends('layouts.app')
@section('title', 'Create new category')
@section('content')
<div class="container py-3">
    <div class="row">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="./">Category</a></li>
                    <li class="breadcrumb-item active">Create new category</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('category.store') }}" method="post">
                @csrf
                @method('post')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                        placeholder="Category Name" id="name" name="name" />
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
