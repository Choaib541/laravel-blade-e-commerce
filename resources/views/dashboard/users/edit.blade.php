@extends('layouts.dashboard')
@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Find user
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form method="get">
                    <div class="input-group ">
                        <input type="number" class="form-control" placeholder="User id" name="id"
                            aria-label="Recipient's username" aria-describedby="button-addon2"
                            value={{ $_GET['id'] ?? '' }}>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="button-addon2">Find User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($user)
        <div class="card shadow m-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Edit User
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form enctype="multipart/form-data" method="POST"
                        action={{ route('dashboard.users') . '/' . $user->id }}>
                        @csrf
                        @method('PATCH')
                        <div class="d-flex mb-3 ">
                            <div class="w-100">
                                <label for="Name">Name</label>
                                <input id="Name" type="text" name="name" class="form-control"
                                    value={{ $user->name }}>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100">
                                <label for="Picture">Picture</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="picture" class="custom-file-input"
                                            id="inputGroupFile02">
                                        <label class="custom-file-label" for="inputGroupFile02"
                                            aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                </div>
                                @error('picture')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="w-100 d-flex flex-column justify-content-stretch">
                                <label for="role_id">Role</label>
                                <select name="role_id" id="role_id" name="role_id" class="form-control">
                                    <option value="1" {{ $user->role_id === 1 ? 'selected' : '' }}>sadmin</option>
                                    <option value="2" {{ $user->role_id === 2 ? 'selected' : '' }}>admin</option>
                                    <option value="3" {{ $user->role_id === 3 ? 'selected' : '' }}>member</option>
                                </select>
                                @error('role_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    value={{ old('email') ?? $user->email }}>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex  mb-3">
                            <div class="w-100">
                                <label for="password">Password</label>
                                <input type="password" step="0.01" name="password" id="password" class="form-control">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mx-2"></div>
                            <div class="w-100 ">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input type="password" step="0.01" name="password_confirmation"
                                    id="password_confirmation" class="form-control">
                                @error('password')
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
                    <div class="text-secondary">Pick An Existing User</div>
                </div>
            </div>
        </div>
    @endif
@endsection
