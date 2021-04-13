@extends('layouts.app')
@section('title', 'User')
@section('content')
<div class="container py-3">
    <div class="row justify-content-md-center">

        {{-- breadcumb --}}
        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>

        {{-- alert --}}
        @if (session()->has('success'))
        <div class="col-md-8 mt-2">
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
        <div class="col-md-8 mt-2">
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

        {{-- table --}}
        <div class="col-md-8 mt-2">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index  }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ Str::ucfirst($user->getRoleNames()[0]) }}</td>
                                <td class="m-0 p-0">
                                    <ul class="m-0 pl-4">
                                        @foreach ($user->permissions as $permission)
                                        <li>{{ ucwords($permission->name) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-primary mr-1 my-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Data empty/not found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end of container --}}
@endsection
