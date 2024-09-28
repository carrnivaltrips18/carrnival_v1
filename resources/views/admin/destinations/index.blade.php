@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Destinations</h1>
        
        <div class="d-flex justify-content-between align-items-center m-2">
            <!-- Left: Create New Admin button -->
            <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary mr-3">Create Destination</a>
            
            <!-- Center: Search Form with margin -->
            <form action="{{ route('admin.destinations.index') }}" method="GET" class="form-inline mr-3">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search Destinations..." value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
    
            <!-- Right: CSV Download Button -->
            <a href="{{ route('admin.destinations.exportCsv') }}" class="btn btn-success">Export CSV</a>
            <form action="{{ route('admin.destinations.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="ml-2">
                @csrf
                <input type="file" name="file" class="form-control-file" required>
                <button type="submit" class="btn btn-info">Import CSV</button>
            </form>
            
            <a href="{{ route('admin.destinations.downloadSampleCsv') }}" class="btn btn-info">Download Sample CSV</a>
        </div>
        
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sno.</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Banner</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Calculate serial number based on pagination
                    $serial = ($destinations->currentPage() - 1) * $destinations->perPage() + 1;
                @endphp
                @foreach($destinations as $destination)
                    <tr>
                        <td>{{ $serial }}</td>
                        <td><a href="{{ route('admin.popular_tours.index', ['search' => $destination->name]) }}">
                            {{ $destination->name }}
                        </a></td>
                        
                        <td>{{ $destination->title }}</td>
                        <td>
                            @if($destination->banner)
                                <img src="{{ asset('storage/' . $destination->banner) }}" width="100" alt="Banner">
                            @else
                                No Banner
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.destinations.toggleStatus', $destination->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $destination->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                    {{ $destination->status == 1 ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.destinations.edit', $destination->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.destinations.destroy', $destination->id) }}" method="POST" style="display:inline-block;" onclick="return confirm('Are you sure,You want to delete ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @php
                    $serial++;
               @endphp
                @endforeach
            </tbody>
        </table>

        {{ $destinations->links() }}
    </div>
@endsection
