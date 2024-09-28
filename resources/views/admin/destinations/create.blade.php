@extends('admin.layout.app')

@section('content')
    <div class="container">
        <h1>Create Destination</h1>
        
        <form action="{{ route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="banner">Banner</label>
                <input type="file" class="form-control" id="banner" name="banner">
            </div>
            <div class="form-group">
                <label for="long_description">Long Description</label>
                <textarea class="form-control" id="long_description" name="long_description">{{ old('long_description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
            </div>
            <div class="form-group">
                <label for="meta_content">Meta Content</label>
                <textarea class="form-control" id="meta_content" name="meta_content">{{ old('meta_content') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
