@extends('layouts.dashboard')
@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                users
            </h6>
        </div>
        <div class="card-body">
            <form class="mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ $_GET['search'] ?? '' }}" name="search"
                        placeholder="Search User..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div>
                        <select class="custom-select rounded-0" name="sort" id="inputGroupSelect01">
                            <option value="id" {{ ($_GET['sort'] ?? '') === 'id' ? 'selected' : '' }}>Id</option>
                            <option value="name" {{ ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="email" {{ ($_GET['sort'] ?? '') === 'email' ? 'selected' : '' }}>Email</option>
                            <option value="role_id" {{ ($_GET['sort'] ?? '') === 'role_id' ? 'selected' : '' }}>Role
                            </option>
                            <option value="created_at" {{ ($_GET['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>
                                Created_at
                            </option>
                            <option value="updated_at" {{ ($_GET['sort'] ?? '') === 'updated_at' ? 'selected' : '' }}>
                                Updated_at
                            </option>
                        </select>
                    </div>
                    <div>
                        <select class="custom-select rounded-0" name="desc" id="inputGroupSelect01">
                            <option value="false" {{ ($_GET['desc'] ?? '') === 'false' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="true" {{ ($_GET['desc'] ?? '') === 'true' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="button-addon2">Search</button>
                    </div>

                </div>
                <div class="d-flex align-items-center input-group">
                    <select name="range" id="range-select" class="form-control">
                        <option {{ ($_GET['range'] ?? false) === 'created_at' ? 'selected' : '' }} value="created_at">
                            Created At</option>
                        <option {{ ($_GET['range'] ?? false) === 'updated_at' ? 'selected' : '' }} value="updated_at">
                            Updated At</option>
                    </select>
                    <label class="m-0 px-3" for="from">From</label>
                    <input id="from" value="{{ $_GET['range_from'] ?? '' }}" name="range_from" class="form-control"
                        placeholder="From" type="number" id="from">
                    <label class="m-0 px-3" for="to">To</label>
                    <input id="to" value="{{ $_GET['range_to'] ?? '' }}" name="range_to" class="form-control"
                        type="number" placeholder="To" id="to">

                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="{{ $sort === 'id' ? 'bg-primary text-white' : '' }}">#</th>
                            <th class="{{ $sort === 'price' ? 'bg-primary text-white' : '' }}">Picture</th>
                            <th class="{{ $sort === 'name' ? 'bg-primary text-white' : '' }}">Name</th>
                            <th class="{{ $sort === 'email' ? 'bg-primary text-white' : '' }}">Email</th>
                            <th class="{{ $sort === 'role_id' ? 'bg-primary text-white' : '' }}">Role</th>
                            <th class="{{ $sort === 'created_at' ? 'bg-primary text-white' : '' }}">Created at</th>
                            <th class="{{ $sort === 'updated_at' ? 'bg-primary text-white' : '' }}">Updated at</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    @if (count($users) === 0)
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center">
                                    Empty users List
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }} </td>
                                    <td>
                                        @if ($user->picture)
                                            <img src={{ asset('storage/' . $user->picture) }}
                                                style="width:45px;height:45px" class="rounded-circle" alt="">
                                        @else
                                            <img src={{ asset('assets/site_images/avatar.png') }}
                                                style="width:45px;height:45px" class="rounded-circle" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}
                                        @if ($user->id === (auth()->user()->id ?? false))
                                            <span class="btn btn-sm btn-success mx-2">Auth</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button
                                            class="{{ 'btn btn-sm btn-' . ($user->role->id === 1 ? 'danger' : ($user->role->id === 2 ? 'warning' : 'success')) }}">
                                            {{ $user->role->name }}
                                        </button>
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        <a href={{ route('dashboard.users.edit') . '?id=' . $user->id }}
                                            class="btn btn-success"><i class="fas fa-solid fa-pen"></i></a>
                                        <form class="d-inline" action="{{ route('dashboard.users') . '/' . $user->id }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger"><i class="fas fa-solid fa-xmark"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif

                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <a href={{ route('dashboard.users.create') }} class="btn btn-primary ">Add new User</a>
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            const lastSelect = document.querySelector("#range-select");
            const from = document.getElementById("from");
            const to = document.getElementById("to");

            function change_type(type) {
                from.type = type;
                to.type = type;
            }
            if (lastSelect.value === "created_at" || lastSelect.value === "updated_at") {
                change_type("datetime-local")
            }
            lastSelect.onchange = (e) => {
                if (e.target.value === "created_at" || e.target.value === "updated_at") {
                    change_type("datetime-local")
                } else {
                    change_type("number")
                }
            }
        </script>
    @endpush
@endsection
