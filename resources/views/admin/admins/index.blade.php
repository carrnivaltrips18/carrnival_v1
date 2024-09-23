@extends('admin.layout.app')

@section('content')
    <h1 class="m-2">Admin Users</h1>

    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary m-2">Create New Admin</a>
     <!-- Search Form -->
     <form action="{{ route('admin.admins.index') }}" method="GET" class="form-inline mb-3 m-2">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search by name or email" value="{{ request('search') }}">
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>
    

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div id="admin-table">
    </div>    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr>
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
            @endforeach
        </tbody>
    </table>
    <!-- Pagination links -->
    <div class="pagination-wrapper">
        {{ $admins->links() }}
    </div>
@endsection

