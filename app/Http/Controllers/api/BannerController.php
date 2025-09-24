<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    function readAll()
    {
        $banner = Banner::all();

        return response()->json([
            'data' => $banner,
        ], 200);
    }
    
     function readAllBanners()
    {
        $banner = Banner::orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        //      if (count($banner) > 0) {
        //         return response()->json([
        //             'data' => $banner,
        //         ], 200);
        //     }else {
        //         return response()->json([
        //             'message' => 'not found',
        //             'data' => $banner,
        //         ], 404);
        // }
            return response()->json([
                    'data' => $banner, // Ini akan [] jika kosong
                    'message' => count($banner) > 0 ? 'Data found' : 'No banners'
                ], 200);
    }
}
