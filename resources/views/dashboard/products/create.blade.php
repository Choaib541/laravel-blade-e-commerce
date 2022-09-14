@extends('layouts.dashboard')
@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Add new Product Product
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.products') }}">
                    @csrf
                    @method('POST')
                    <div class="d-flex mb-3 ">
                        <div class="w-100">
                            <label for="Title">Title</label>
                            <input id="Title" type="text" name="title" class="form-control"
                                value={{ old('title') }}>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mx-2"></div>
                        <div class="w-100">
                            <label for="description">Description</label>
                            <input id="description" type="text" name="description" class="form-control"
                                value={{ old('description') }}>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="w-100 d-flex flex-column justify-content-stretch">
                            <label for="in_stcock">In Stock</label>
                            <select name="in_stock" id="in_stcock" name="in_stock" class="form-control">
                                <option {{ old('description') ?? false ? 'selected' : 'false' }} selected value="1">
                                    True</option>
                                <option {{ old('description') ?? false ? 'selected' : 'false' }} value="0">
                                    False</option>
                            </select>
                            @error('in_stcock')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mx-2"></div>
                        <div class="w-100">
                            <label for="stock">Stock</label>
                            <input type="text" id="stock" name="stock" class="form-control"
                                value={{ old('stock') }}>
                            @error('stock')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex  mb-3">
                        <div class="w-100">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" name="price" id="price" class="form-control"
                                value={{ old('price') }}>
                            @error('price')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mx-2"></div>
                        <div class="w-100 ">
                            <label for="price">Image</label>
                            <input type="file" name="image" class="w-100">
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-success">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
