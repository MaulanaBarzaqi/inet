<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Helpers\CategoryHelper;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;


class CategoryController extends Controller
{   
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $items = Category::withCount('internetPackages')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10)
                            ->withQueryString();

        if (request()->has('search')) {
            $search = request()->input('search');
            $items = Category::withCount('internetPackages')
                                ->where('name', 'like', "%$search%")
                                ->orWhere('description', 'like', "%$search%")
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        }
        return view('pages.category.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            // Generate unique slug
            $slug = CategoryHelper::generateUniqueSlug($request->name);
            // Create category
            Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description
            ]);
            return redirect()->route('category.index');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('pages.category.edit')->with([
            'item' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            // Generate new slug if name changed
            if ($category->name != $request->name) {
                $slug = CategoryHelper::generateUniqueSlug($request->name, $category->id);
                $category->slug = $slug;
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return redirect()->route('category.index');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
         try {
            $item = $category;
            $item->delete();

            return redirect()->route('category.index');
        } catch (\Exception $e) {
            return redirect()->route('category.index')
                 ->with('error', 'Gagal menghapus category: ' . $e->getMessage());
        }
    }
}
