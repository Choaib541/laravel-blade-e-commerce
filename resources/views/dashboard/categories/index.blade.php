@extends('layouts.dashboard')
@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                categories
            </h6>
        </div>
        <div class="card-body">
            <form class="mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" value="{{ $_GET['search'] ?? '' }}" name="search"
                        placeholder="Search category..." aria-label="Recipient's categoryname"
                        aria-describedby="button-addon2">
                    <div>
                        <select class="custom-select rounded-0" name="sort" id="inputGroupSelect01">
                            <option value="id" {{ ($_GET['sort'] ?? '') === 'id' ? 'selected' : '' }}>Id</option>
                            <option value="name" {{ ($_GET['sort'] ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="created_at" {{ ($_GET['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>
                                Created_at
                            </option>
                            <option value="updated_at" {{ ($_GET['sort'] ?? '') === 'updated_at' ? 'selected' : '' }}>
                                Updated_at
                            </option>
                        </select>
                    </div>
                    <div>
                        <select class="custom-select rounded-0" name="direc" id="inputGroupSelect01">
                            <option value="desc" {{ ($_GET['direc'] ?? '') === 'desc' ? 'selected' : '' }}>Descending
                            </option>
                            <option value="asc" {{ ($_GET['direc'] ?? '') === 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="button-addon2">Search</button>
                    </div>

                </div>
                <div class="d-flex align-items-center input-group">
                    <select name="range_option" id="range-select" class="form-control">
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
                            <th class="{{ ($_GET['sort'] ?? false) === 'id' ? 'bg-primary text-white' : '' }}">#</th>
                            <th class="{{ ($_GET['sort'] ?? false) === 'price' ? 'bg-primary text-white' : '' }}">Picture
                            </th>
                            <th class="{{ ($_GET['sort'] ?? false) === 'name' ? 'bg-primary text-white' : '' }}">Name</th>
                            <th class="{{ ($_GET['sort'] ?? false) === 'created_at' ? 'bg-primary text-white' : '' }}">
                                Created at</th>
                            <th class="{{ ($_GET['sort'] ?? false) === 'updated_at' ? 'bg-primary text-white' : '' }}">
                                Updated at</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    @if (count($categories) === 0)
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center">
                                    Empty categories List
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        {{ $category->id }}
                                    </td>
                                    <td>
                                        <img src={{ asset('storage/' . $category->image) }} class="rounded-circle"
                                            style="width:45px;height:45px;" alt="">
                                    </td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        {{ $category->created_at }}
                                    </td>
                                    <td>
                                        {{ $category->updated_at }}
                                    </td>
                                    <td>
                                        <a href={{ route('dashboard.categories.edit') . '?id=' . $category->id }}
                                            class="btn btn-success"><i class="fas fa-solid fa-pen"></i></a>
                                        <form class="d-inline"
                                            action="{{ route('dashboard.categories') . '/' . $category->id }}"
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
                    <a href={{ route('dashboard.categories.create') }} class="btn btn-primary ">Add new category</a>
                    {{ $categories->links() }}
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
