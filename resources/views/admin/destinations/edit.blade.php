@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Edit Destination</h1>
        
        <form action="{{ route('admin.destinations.update', $destination->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $destination->name) }}" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $destination->title) }}" required>
            </div>
            <div class="form-group">
                <label for="banner">Banner</label>
                @if($destination->banner)
                    <img src="{{ asset('storage/' . $destination->banner) }}" width="200" height="150" alt="Banner">

                @endif
                <input type="file" class="form-control" id="banner" name="banner">
            </div>
            <div class="form-group">
                <label for="long_description">Long Description</label>
                <textarea class="form-control" id="long_description" name="long_description">{{ old('long_description', $destination->long_description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $destination->meta_title) }}">
            </div>
            <div class="form-group">
                <label for="meta_content">Meta Content</label>
                <textarea class="form-control" id="meta_content" name="meta_content">{{ old('meta_content', $destination->meta_content) }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
