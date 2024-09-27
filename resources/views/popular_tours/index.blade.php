@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1>Popular Tours</h1>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('popular_tours.create') }}" class="btn btn-primary">Create New Tour</a>
        
        <!-- Search Form -->
        <form action="{{ route('popular_tours.index') }}" method="GET" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search Tours..." value="{{ request()->get('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
        
        <!-- CSV Export Button -->
        <a href="{{ route('popular_tours.exportCsv') }}" class="btn btn-success m-2">Export CSV</a>
        <form action="{{ route('popular_tours.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="ml-2">
            @csrf
            <input type="file" name="file" class="form-control-file" required>
            <button type="submit" class="btn btn-info">Import CSV</button>
        </form>
        <a href="{{ route('popular_tour.downloadSampleCsv') }}" class="btn btn-info">Download Sample CSV</a>

    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Package Name</th>
                <th>Duration</th>
                <th>Price</th>
                <th>Inclusion</th>
                {{-- <th>Package Image</th> --}}
                <th>Destination</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($popularTours as $tour)
                <tr>
                    <td>{{ $tour->package_name }}</td>
                    <td>{{ $tour->duration }} </td>
                    <td>₹{{ number_format($tour->price, 2) }}</td>
                    <td>{{ $tour->inclusion }}</td>
                    {{-- <td>
                        @if($tour->package_image)
                            <img src="{{ asset('storage/' . $tour->package_image) }}" width="100" alt="Package Image">
                        @else
                            No Image
                        @endif
                    </td> --}}
                    <td>{{ $tour->destination->name }}</td>
                    <td>
                        <a href="{{ route('popular_tours.edit', $tour->id) }}" class="btn btn-warning m-2">Edit</a>
                        <form action="{{ route('popular_tours.destroy', $tour->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this tour?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $popularTours->links() }}
</div>
@endsection
