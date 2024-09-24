@extends('admin.layout.app')

@section('content')
<div class="card m-4">
    <legend class="bg-secondary p-1 text-center">
        <h3>Company Details</h3>
    </legend>
    <div class="container bg-light p-3">
        <!-- Company Logo and Fav Icon -->
        <div class="row m-3">
            <div class="col text-center">
                <label><strong>Logo</strong></label><br>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="img-thumbnail" style="max-width: 150px;">
                @else
                    <p>No logo uploaded.</p>
                @endif
            </div>
            <div class="col text-center">
                <label><strong>Fav Icon</strong></label><br>
                @if($company->fav_icon)
                    <img src="{{ asset('storage/' . $company->fav_icon) }}" alt="Favicon" class="img-thumbnail" style="max-width: 50px;">
                @else
                    <p>No favicon uploaded.</p>
                @endif
            </div>
        </div>

        <!-- Company Details -->
        <table class="table table-striped mt-3">
            <tr>
                <th>Name</th>
                <td>{{ $company->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $company->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{{ $company->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Website</th>
                <td>{{ $company->website }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $company->address ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $company->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Facebook</th>
                <td>{{ $company->facebook ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>LinkedIn</th>
                <td>{{ $company->linkedin ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Instagram</th>
                <td>{{ $company->instagram ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Twitter</th>
                <td>{{ $company->twitter ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
    
    <div class="text-center m-2">
        <a href="{{ route('admin.company.edit') }}" class="btn btn-primary">Edit Company Details</a>
    </div>
</div>
@endsection
