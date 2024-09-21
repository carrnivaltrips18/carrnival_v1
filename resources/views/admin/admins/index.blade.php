@extends('admin.layout.app')

@section('content')
    <h1>Admin Users</h1>

    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">Create New Admin</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->roles->pluck('name')->join(', ') }}</td>
                    <td>
                        <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
