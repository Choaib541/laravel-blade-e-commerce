@extends('layouts.auth')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" action={{ route('store') }} method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gap-10">
                                <div class="col-6 p-0 pr-2 mb-3">
                                    <input value="{{ old('name') }}" placeholder="Name..." type='text' name='name'
                                        class="form-control" />
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-6  p-0 mb-3">
                                    <input value="{{ old('email') }}" placeholder="Email Address..." type='email'
                                        name='email' class="form-control" />
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="picture" class="custom-file-input"
                                            id="inputGroupFile02">
                                        <label class="custom-file-label" for="inputGroupFile02"
                                            aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-6 p-0 pr-2 mb-3">
                                    <input type='password' placeholder="Password..." name='password' class="form-control" />
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-6 p-0  mb-3">
                                    <input type='password' placeholder="Repeat Password..." name='password_confirmation'
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary btn-md">Register</button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href={{ route('login') }}>Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
