@extends('layouts.dashboard')
@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Find Product
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="get">
                    <div class="input-group ">
                        <input type="number" class="form-control" placeholder="Product id" name="id"
                            aria-label="Recipient's username" aria-describedby="button-addon2"
                            value={{ $_GET['id'] ?? '' }}>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="button-addon2">Find Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($product)
        <div class="card shadow m-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Edit Product
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form enctype="multipart/form-data" method="POST" action={{ '/dashboard/products/' . $product->id }}>
                        @csrf
                        @method('PATCH')
                        <div class="d-flex mb-3 ">
                            <div class="w-100">
                                <label for="Title">Title</label>
                                <input id="Title" type="text" name="title" class="form-control"
                                    value={{ $product->title }}>
                                @error('title')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100">
                                <label for="description">Description</label>
                                <input id="description" type="text" name="description" class="form-control"
                                    value={{ $product->description }}>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="w-100 d-flex flex-column justify-content-stretch">
                                <label for="in_stcock">In Stock</label>
                                <select name="in_stock" id="in_stcock" name="in_stock" class="form-control">
                                    <option value="0" {{ $product->in_stock === 0 ? 'selected' : '' }}>False</option>
                                    <option value="1" {{ $product->in_stock === 1 ? 'selected' : '' }}>True</option>
                                </select>
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100">
                                <label for="stock">Stock</label>
                                <input type="text" id="stock" name="stock" class="form-control"
                                    value={{ $product->stock }}>
                                @error('stock')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex  mb-3">
                            <div class="w-100">
                                <label for="price">Price</label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control"
                                    value={{ $product->price }}>
                                @error('price')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100 d-flex align-items-end">
                                <input type="file" name="image" class="w-100">
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
    @else
        <div class="card shadow m-4">
            <div class="card-header py-3 ">
                <h6 class="m-0 font-weight-bold text-primary">
                    Hint
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="text-secondary">Pick An Existing Product</div>
                </div>
            </div>
        </div>
    @endif
@endsection
