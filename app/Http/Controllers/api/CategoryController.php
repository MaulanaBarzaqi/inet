<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function readAllCategories()
    {
        $category = Category::orderBy('created_at', 'desc')->get();

         return response()->json([
                    'message' => count($category) > 0 ? 'Data found' : 'No categories',
                    'data' => $category,
                ], 200);
    }
}
