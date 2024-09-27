@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Destinations</h1>
        {{-- <form action="{{ route('destinations.uploadCsv') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Upload CSV file</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload CSV</button>
        </form> --}}
        
        <div class="d-flex justify-content-between align-items-center m-2">
            <!-- Left: Create New Admin button -->
            <a href="{{ route('destinations.create') }}" class="btn btn-primary mr-3">Create Destination</a>
            
            <!-- Center: Search Form with margin -->
            <form action="{{ route('destinations.index') }}" method="GET" class="form-inline mr-3">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search Destinations..." value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
    
            <!-- Right: CSV Download Button -->
            <a href="{{ route('destinations.exportCsv') }}" class="btn btn-success">Export CSV</a>
            <form action="{{ route('destinations.uploadCsv') }}" method="POST" enctype="multipart/form-data" class="ml-2">
                @csrf
                <input type="file" name="file" class="form-control-file" required>
                <button type="submit" class="btn btn-info">Import CSV</button>
            </form>
            
            <a href="{{ route('destinations.downloadSampleCsv') }}" class="btn btn-info">Download Sample CSV</a>
        </div>
        
        
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
                    <th>Status</th>
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
                            <form action="{{ route('destinations.toggleStatus', $destination->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $destination->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                    {{ $destination->status == 1 ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
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
