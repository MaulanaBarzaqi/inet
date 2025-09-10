<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
      function readAll()
    {
        $banner = Category::all();

        return response()->json([
            'data' => $banner,
        ], 200);
    }

    function readAllCategories()
    {
        $category = Category::orderBy('created_at', 'asc')->get();

        if (count($category) > 0) {
            return response()->json([
                'data' => $category,
            ], 200);
        }else {
            return response()->json([
                'message' => 'not found',
                'data' => $category,
            ], 404);
        }
    }
}
