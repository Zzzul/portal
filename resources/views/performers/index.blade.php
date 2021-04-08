@extends('layouts.app')
@section('title', 'Performer')
@section('content')
<div class="container py-3">
    <div class="row justify-content-md-center">

        {{-- breadcumb --}}
        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Performer</li>
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
                    <a href="{{ route('performer.create') }}" class="btn btn-primary mb-3 float-right">
                        <i class="fas fa-plus mr-1"></i>
                        Create new performer</a>

                    <table class="table table-hover table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($performers as $index => $performer)
                            <tr>
                                <td>{{ $performers->firstItem() + $index  }}</td>
                                <td>{{ $performer->name }}</td>
                                <td>{{ $performer->created_at->diffForHumans() }}</td>
                                <td>{{ $performer->updated_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{ route('performer.edit', $performer->id) }}"
                                        class="btn btn-sm btn-outline-primary mr-1 my-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <a href="#" data-id={{ $performer->id }} data-toggle="modal"
                                        data-target="#deleteModal" class="btn btn-sm btn-outline-danger btn-delete">
                                        <i class="fas fa-trash-alt"></i>
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

                    {{ $performers->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end of container --}}

<!-- Delete Warning Modal -->
<div class="modal modal-danger fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete performer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('performer.destroy') }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <input id="id" name="id" type="hidden">
                    <h5>Are you sure to delete this performer?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->
@endsection

@section('scripts')
<script>
    $(document).on('click', '.btn-delete', function(){
        let id = $(this).attr('data-id');
        $('#id').val(id);
        console.log(id)
    });
</script>
@endsection
