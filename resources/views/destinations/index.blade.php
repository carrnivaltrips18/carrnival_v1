@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Destinations</h1>
        <a href="{{ route('destinations.create') }}" class="btn btn-primary">Create Destination</a>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Banner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destinations as $destination)
                    <tr>
                        <td>{{ $destination->name }}</td>
                        <td>{{ $destination->title }}</td>
                        <td>
                            @if($destination->banner)
                                <img src="{{ asset('storage/' . $destination->banner) }}" width="100" alt="Banner">
                            @else
                                No Banner
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('destinations.edit', $destination->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('destinations.destroy', $destination->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $destinations->links() }}
    </div>
@endsection
