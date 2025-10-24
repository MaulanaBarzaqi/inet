<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InternetPackage;

class InternetPackageController extends Controller
{
    function readAllInternetPackages()
    {
        $internetPackage = InternetPackage::with('category')
                            ->orderBy('monthly_bill', 'asc')
                            ->get();
          return response()->json([
                    'message' => count($internetPackage) > 0 ? 'Data found' : 'No internet packages',
                    'data' => $internetPackage,
                ], 200);
    }

    function readByCategory($categorySlug)
    {
        $internetPackage = InternetPackage::with('category')
            ->whereHas('category', function($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            })
            ->orderBy('name')
            ->get();
            
             if (count($internetPackage) > 0) {
                return response()->json([
                    'data' => $internetPackage,
                ], 200);
            }else {
                return response()->json([
                    'message' => 'not found',
                    'data' => $internetPackage,
                ], 404);
        }
    }

    function searchByName($name)
    {
        $internetPackage = InternetPackage::with('category')
                           ->where('name', 'like', "%{$name}%")
                           ->orderBy('name')
                           ->get();

        return response()->json([
                    'message' => count($internetPackage) > 0 ? 'Data found' : 'No result on' . $name,
                    'data' => $internetPackage,
                ], 200);
    }
    

}
