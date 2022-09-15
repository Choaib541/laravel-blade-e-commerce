<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = new User();
        $sort = request()->sort ?? "id";
        $desc = request()->desc ?? false;
        $search = request()->search ?? "";
        $range = request()->range ?? false;
        $range_from = request()->range_from ?? false;
        $range_to = request()->range_to ?? false;

        $users = $users->search($search, [
            "range" => $range,
            "range_from" => $range_from,
            "range_to" => $range_to,
        ]);

        if ($desc !== false) {
            $users = $users->orderBy($sort,  $desc === "true" ? "desc" : "asc");
        } else {
            $users = $users->orderBy("id", "desc");
        }

        $users = $users->paginate(8);

        // ------------

        return view("dashboard.users.index", ["users" => $users, "sort" => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email"],
            "role_id" => ["required", "integer"],
            "password" => ["nullable", "min:8", "confirmed"],
            "picture" => ["nullable"]
        ]);

        $validated["password"] = bcrypt($validated["password"]);

        if ($request->hasFile("picture")) {
            $validated["password"] = $request->file("picture")->store("products_image", "public");
        }

        User::create($validated);

        return back()->with("success", "User Added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
    //  * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = null;

        if ($request->id) {
            $user = User::find($request->id);
        }

        return view("dashboard.users.edit", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email"],
            "role_id" => ["required", "integer"],
            "password" => ["nullable", "min:8", "confirmed"],
        ]);

        if ($validated["password"]) {
            $validated["password"] = bcrypt($validated["password"]);
        } else {
            unset($validated["password"]);
        }

        $user = User::find($id);

        if ($validated["email"] !== $user->email) {
            $request->validate([
                "email" => ["required", "email", "unique:users,email"],
            ]);
        }

        if ($request->hasFile("picture")) {
            if ($user->picture && file_exists(public_path("storage/" . $user->picture))) {
                File::delete(public_path("storage/" . $user->picture));
            }
            $validated["picture"] = $request->file("picture")->store("users_avatar", "public");
        }

        $user->update($validated);

        // return back()->with("success", "User updated successfully");
        return redirect(route("dashboard.users"))->with("success", "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return back()->with("success", "deleted successfully");
    }
}
