@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Assign Permission to Admin</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.assign.permission') }}">
        @csrf
        
        <div class="mb-3">
            <label for="admin_id" class="form-label">Select Admin</label>
            <select name="admin_id" class="form-select" required>
                <option value="">Select Admin</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="permission" class="form-label">Select Permission</label>
            <select name="permission" class="form-select" required>
                <option value="">Select Permission</option>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Assign Permission</button>
    </form>
    <button onclick="window.history.back();" class="btn btn-secondary mt-3">Back</button>
</div>
@endsection
