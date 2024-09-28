@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1>Itineraries</h1>
    
    <div class="d-flex justify-content-between align-items-center m-2">
        <a href="{{ route('admin.itineraries.create') }}" class="btn btn-primary mr-3">Create Itinerary</a>
        <form action="{{ route('admin.itineraries.index') }}" method="GET" class="form-inline mr-3">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search Itineraries..." value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno.</th>
                <th>Day No</th>
                <th>Title</th>
                <th>Location</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php $serial = ($itineraries->currentPage() - 1) * $itineraries->perPage() + 1; @endphp
            @foreach($itineraries as $itinerary)
                <tr>
                    <td>{{ $serial }}</td>
                    <td>{{ $itinerary->day_no }}</td>
                    <td>{{ $itinerary->title }}</td>
                    <td>{{ $itinerary->location }}</td>
                    <td>{{ $itinerary->description }}</td>
                    <td>
                        <a href="{{ route('admin.itineraries.edit', $itinerary->id) }}" class="btn btn-warning m-2">Edit</a>
                        <form action="{{ route('admin.itineraries.destroy', $itinerary->id) }}" method="POST" style="display:inline-block;" onclick="return confirm('Are you sure, You want to delete?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @php $serial++; @endphp
            @endforeach
        </tbody>
    </table>

    {{ $itineraries->links() }}
</div>
@endsection
