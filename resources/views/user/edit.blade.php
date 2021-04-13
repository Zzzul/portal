@extends('layouts.app')
@section('title', 'Edit User - ' . $user->name)
@section('content')
<div class="container py-3">
    <div class="row justify-content-md-center">

        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{--  --}}
                    <form action="{{ route('user.update', $user->id) }}" method="post">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name')is-invalid @enderror"
                                placeholder="user Name" id="name" name="name" value="{{ old('title', $user->name) }}" />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email')is-invalid @enderror"
                                placeholder="user email" id="email" name="email"
                                value="{{ old('email', $user->email) }}" />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="roles">Roles</label>
                            <select name="roles" id="roles" name="roles"
                                class="form-control @error('roles')is-invalid @enderror">
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ $role->name == $user->getRoleNames()[0] ? 'selected' : '' }}>
                                    {{ Str::ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                            @error('roles') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="form-group row @error('permsission')text-danger @enderror">

                            <div class="col-md-6">
                                <Label>Permissions</Label>
                                @foreach ($user->permissions as $permsission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        id="permsission-id-{{ $permsission->id }}" value="{{ $permsission->id }}"
                                        checked>
                                    <label class="form-check-label" for="permsission-id-{{ $permsission->id }}">
                                        {{ ucwords($permsission->name) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="col-md-6 mt-4">
                                @foreach ($not_user_permissions as $not_user_permsission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        id="permsission-id-{{ $not_user_permsission->id }}"
                                        value="{{ $not_user_permsission->id }}">
                                    <label class="form-check-label"
                                        for="permsission-id-{{ $not_user_permsission->id }}">
                                        {{ ucwords($not_user_permsission->name) }}
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
