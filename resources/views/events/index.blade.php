@extends('layouts.app')
@section('title', 'Event')
@section('content')
<div class="container py-3">
    <div class="row">

        {{-- breadcumb --}}
        <div class="col-md-12">
            <div class="d-none d-md-block">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Event</li>
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

        @if (session()->has('error'))
        <div class="col-md-12 mt-2">
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
        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('event.create') }}" class="btn btn-primary mb-3 float-right">
                        <i class="fas fa-plus"></i>
                        Create new event</a>

                    <a href="{{ route('event.check-payment-status-form') }}" class="btn btn-dark mb-3 float-right mr-2">
                        <i class="fas fa-dollar"></i>
                        Check payment status</a>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Performers</th>
                                    <th>Start Time</th>
                                    <th>Finish Time</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                    <th>Registered Audiences</th>
                                    <th>Max Audience</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($events as $index => $event)
                                <tr>
                                    <td>{{ $events->firstItem() + $index  }}</td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event['category']->name }}</td>
                                    <td>
                                        <ul class="ml-0 pl-3">
                                            @foreach ($event->performers as $performer)
                                            <li>{{  Str::ucfirst($performer->name) }} </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ date('d F Y H:i', strtotime($event->start_time)) }}</td>
                                    <td>{{ date('d F Y H:i', strtotime($event->finish_time)) }}</td>
                                    <td>{{ $event->location }}</td>
                                    <td>Rp. {{ number_format($event->price, 0,',','.') }}</td>
                                    <td>{{ count($event->audiences) }}</td>
                                    <td>{{ $event->max_audience }}</td>
                                    <td>{{ $event->created_at->diffForHumans() }}</td>
                                    <td>{{ $event->updated_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{ route('event.edit', $event->id) }}"
                                            class="btn btn-sm btn-outline-primary mr-1 my-1">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a href="{{ route('event.show', $event->id) }}"
                                            class="btn btn-sm btn-outline-success mr-1 my-1">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="#" data-id={{ $event->id }} data-toggle="modal"
                                            data-target="#deleteModal" class="btn btn-sm btn-outline-danger btn-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="13" class="text-center">Data empty/not found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $events->links('pagination::bootstrap-4') }}
                </div>
            </div>
            {{-- end of card --}}
        </div>
        {{-- end of col --}}
    </div>
    {{-- end of row --}}
</div>
{{-- end of container --}}

<!-- Delete Warning Modal -->
<div class="modal modal-danger fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Delete"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('event.destroy') }}" method="post">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <input id="id" name="id" type="hidden">
                    <h5>Are you sure to delete this event?</h5>
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
