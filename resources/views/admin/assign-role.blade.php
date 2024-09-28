@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Assign Role to Admin</h1>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.admins.index') }}" class="btn btn-primary">Manage Admins</a>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h2 class="card-title text-center">Assign Role</h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form method="POST" action="{{ route('admin.assign.role') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="admin_id" class="form-label">Select Admin</label>
                    <select name="admin_id" id="admin_id" class="form-select" required>
                        <option value="">Select Admin</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ ucfirst($admin->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="role" class="form-label">Select Role</label>
                    <select name="role" id="role" class="form-select" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Assign Role</button>
                    <button type="button" onclick="window.history.back();" class="btn btn-secondary">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
