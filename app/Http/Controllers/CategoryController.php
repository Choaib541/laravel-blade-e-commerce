<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new Category();
        $sort = request()->sort ?? "id";
        $desc = request()->desc ?? false;
        $search = request()->search ?? "";
        $range = request()->range ?? false;
        $range_from = request()->range_from ?? false;
        $range_to = request()->range_to ?? false;

        $categories = $categories->search($search, [
            "range" => $range,
            "range_from" => $range_from,
            "range_to" => $range_to,
        ]);

        if ($desc !== false) {
            $categories = $categories->orderBy($sort,  $desc === "true" ? "desc" : "asc");
        } else {
            $categories = $categories->orderBy("id", "desc");
        }

        $categories = $categories->paginate(8);

        // ------------
        return view("dashboard.categories.index", ["categories" => $categories, "sort" => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.categories.create");
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

            "name" => ["required", "min:3", "unique:categories,name"],
            "image" => ["required"],

        ]);

        $validated["image"] = $request->file("image")->store("categories_images", "public");

        Category::create($validated);

        return back()->with("success", "category created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $category = null;
        $id = request()->id ?? false;
        if (request()->id) {
            $category = Category::find($id);
        }

        return view("dashboard.categories.edit", ["category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => ["required", "min:3"],
            "image" => ["nullable"],
        ]);

        $category = Category::find($id);

        if ($category->name !== $validated["name"]) {
            $validated = $request->validate([
                "name" => ["required", "min:3", "unique:categories,name"],
                "image" => ["nullable"],
            ]);
        }

        if ($request->hasFile("image")) {
            File::delete(public_path("storage/" . $category->image));
            $validated["image"] = $request->file("image")->store("categories_images", "public");
        }

        $category->update($validated);
        return back()->with("success", "Category Created successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return back()->with("success", "deleted successfully");
    }
}
