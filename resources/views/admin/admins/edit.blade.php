@extends('admin.layout.app')

@section('content')
    <h1>Edit Admin User</h1>

    <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $admin->email }}" required>
        </div>

        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role" class="form-control" required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $admin->roles->contains('name', $role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="permissions">Permissions:</label>
            {{-- <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ $admin->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select> --}}
            <select name="permissions[]" class="form-control" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ $admin->permissions->contains('name', $permission->name) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Admin</button>
    </form>
@endsection
