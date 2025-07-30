<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InternetPackage;

class InternetPackageController extends Controller
{
    function readAll()
    {
        $internetPackage = InternetPackage::all();

        return response()->json([
            'data' => $internetPackage,
        ], 200);
    }

    function readRecommendationLimit()
    {
        $internetPackage = InternetPackage::orderBy('monthly_bill', 'asc')
            ->limit(5)
            ->get();

            if(count($internetPackage) > 0) {
                return response()->json([
                    'data' => $internetPackage,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'data' => $internetPackage,
                ], 404);
            }
    }

    function readByCategoryCorporate()
    {
        $internetPackage = InternetPackage::where('category', 'corporate')
            ->orderBy('name')
            ->get();

        if (count($internetPackage) > 0) {
            return response()->json([
                'data' => $internetPackage,
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $internetPackage,
            ], 404);
        }
    }

    function readByCategoryStudent()
    {
        $internetPackage = InternetPackage::where('category', 'pelajar')
            ->orderBy('name')
            ->get();

        if (count($internetPackage) > 0) {
            return response()->json([
                'data' => $internetPackage,
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $internetPackage,
            ], 404);
        }
    }

    function readByCategoryFamily()
    {
        $internetPackage = InternetPackage::where('category', 'keluarga')
            ->orderBy('name')
            ->get();

        if (count($internetPackage) > 0) {
            return response()->json([
                'data' => $internetPackage,
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'data' => $internetPackage,
            ], 404);
        }
    }

    function searchByName($name)
    {
        $internetPackage = InternetPackage::query()
            ->where('name', 'like', "%{$name}%")
            ->orderBy('name')
            ->get();
        
        if (count($internetPackage) > 0) {
            return response()->json([
                'data' => $internetPackage,
            ], 200);
        }else {
            return response()->json([
                'message' => 'not found ' . $name,
                'data' => $internetPackage, 
            ], 404);
        }
    }

}
