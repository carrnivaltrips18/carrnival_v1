@extends('admin.layout.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<form action="{{ route('admin.company.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card m-4">
        <legend class="bg-secondary p-1 text-center">
            <h3>Edit Master</h3>
        </legend>
        <div class="container bg- p-2">
            <div class="row m-3">
                <div class="col">
                    <label for="logo">Logo</label>
                    <input type="file" class="form-control" name="logo" id="logo">
                    <p class="text-danger">Old image
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="img-thumbnail" width="100">
                    </p>
                </div>
                <input type="hidden" name="id" value="">
                <div class="col">
                    <label for="fav_icon">Fav Icon</label>
                    <input type="file" class="form-control" name="fav_icon" id="fav_icon">
                    <p class="text-danger">Old fav icon
                        <span><img src="{{ asset('storage/' . $company->fav_icon) }}" width="20rem" alt=""></span>
                    </p>
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <label for="company_title">Company Title</label>
                    <input type="text" class="form-control" name="name" id="company_title" value="{{ $company->name }}">
                </div>
                <div class="col">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" onkeypress="return isNumberKey(event)" maxlength="10" value="1234567890">
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $company->email }}">
                </div>
                <div class="col">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ $company->address }}">
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="4">{{ $company->description }}</textarea>
                </div>
                <div class="col">
                    <label for="facebook">Facebook</label>
                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $company->facebook }}">
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <label for="twitter">Linkedin</label>
                    <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $company->linkedin }}">
                </div>
                <div class="col">
                    <label for="instagram">Instagram</label>
                    <input type="text" class="form-control" name="instagram" id="instagram" value="{{ $company->instagram }}">
                </div>
            </div>
            <div class="row m-3">
                <div class="col">
                    <label for="twitter">Twitter</label>
                    <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $company->twitter }}">
                </div>
                <div class="col">
                    <label for="instagram">Site Url</label>
                    <input type="text" class="form-control" name="website" id="website" value="{{ $company->website }}">
                </div>
            </div>
        </div>
        <div class="text-center m-2">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </div>
</form>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endsection