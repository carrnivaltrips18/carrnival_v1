@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Create Popular Tour</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.popular_tours.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="package_name">Package Name</label>
                <input type="text" name="package_name" id="package_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" name="duration" id="duration" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="inclusion">Inclusion</label>
                <textarea name="inclusion" id="inclusion" class="form-control" ></textarea>
            </div>

            <div class="form-group">
                <label for="destination_id">Select Destination</label>
                <select name="destination_id" id="destination_id" class="form-control" required>
                    <option value="">Select Destination</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="form-group">
                <label for="package_image">Package Image (optional)</label>
                <input type="file" name="package_image" id="package_image" class="form-control" accept="image/*">
            </div> --}}

            <button type="submit" class="btn btn-primary">Create Popular Tour</button>
            <a href="{{ route('admin.popular_tours.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
