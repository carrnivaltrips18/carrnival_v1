@extends('layouts.app_admin')

@section('content')
<div class="container">
    <h2>Assign Role to Admin</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <form method="POST" action="{{ route('admin.assign.role') }}">
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
            <label for="role" class="form-label">Select Role</label>
            <select name="role" class="form-select" required>
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Assign Role</button>
    </form>
</div>
@endsection
