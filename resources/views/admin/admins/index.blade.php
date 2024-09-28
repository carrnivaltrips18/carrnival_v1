@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1 class="m-2">Admin Users</h1>
    <!-- Flexbox with spacing between elements -->
    <div class="d-flex justify-content-between align-items-center m-2">
        <!-- Left: Create New Admin button -->
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mr-3">Create New Admin</a>
        
        <!-- Center: Search Form with margin -->
        <form action="{{ route('admin.admins.index') }}" method="GET" class="form-inline mr-3">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search by name or email" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>

        <!-- Right: CSV Download Button -->
        <a href="{{ route('admin.users.csv') }}" class="btn btn-success">Download CSV</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div id="admin-table">
    </div>    
    <table class="table">
        <thead>
            <tr>
                <th>Sno.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
            // Calculate serial number based on pagination
            $serial = ($admins->currentPage() - 1) * $admins->perPage() + 1;
        @endphp
            @foreach ($admins as $admin)
                <tr>
                    <td>{{ $serial }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->roles->pluck('name')->join(', ') }}</td>
                    <td>
                        <!-- Status Toggle Button -->
                        <form action="{{ route('admin.admins.toggleStatus', $admin->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $admin->status ? 'success' : 'warning' }}">
                                {{ $admin->status ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @php
                    $serial++;
               @endphp
            @endforeach
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="pagination-wrapper">
        {{ $admins->links() }}
    </div>
</div>
   
@endsection

