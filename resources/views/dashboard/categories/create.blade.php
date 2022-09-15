@extends('layouts.dashboard')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Add neww category
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form enctype="multipart/form-data" method="POST" action={{ route('dashboard.categories') }}>
                    @csrf
                    <div class="d-flex ">
                        <div class="w-100">
                            <label for="Name">Name</label>
                            <input id="Name" type="text" name="name" class="form-control"
                                value={{ old('name') }}>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mx-2"></div>
                        <div class="w-100">
                            <label>Image</label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02"
                                        aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
