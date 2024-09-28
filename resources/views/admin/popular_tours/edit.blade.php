@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1>Edit Popular Tour</h1>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.popular_tours.update', $popularTour->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="package_name">Package Name</label>
            <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name', $popularTour->package_name) }}" required>
        </div>

        <div class="form-group">
            <label for="duration">Duration</label>
            <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration', $popularTour->duration) }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $popularTour->price) }}" required>
        </div>

        <div class="form-group">
            <label for="inclusion">Inclusion</label>
            <textarea name="inclusion" id="inclusion" class="form-control" rows="4" >{{ old('inclusion', $popularTour->inclusion) }}</textarea>
        </div>

        {{-- <div class="form-group">
            <label for="package_image">Package Image</label>
            <input type="file" name="package_image" id="package_image" class="form-control-file">
            @if($popularTour->package_image)
                <img src="{{ asset('storage/' . $popularTour->package_image) }}" width="100" alt="Current Package Image">
            @else
                <p>No current image</p>
            @endif
        </div> --}}

        <div class="form-group">
            <label for="destination_id">Destination</label>
            <select name="destination_id" id="destination_id" class="form-control" required>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}" {{ $popularTour->destination_id == $destination->id ? 'selected' : '' }}>
                        {{ $destination->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Tour</button>
        <a href="{{ route('admin.popular_tours.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
