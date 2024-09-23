@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="card-title text-center">Assign Permission to Admin</h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <form method="POST" action="{{ route('admin.assign.permission') }}">
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
                    <label for="permission" class="form-label">Select Permission</label>
                    <select name="permission" id="permission" class="form-select" required>
                        <option value="">Select Permission</option>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ ucfirst($permission->name) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Assign Permission</button>
                    <button onclick="window.history.back();" class="btn btn-secondary">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
