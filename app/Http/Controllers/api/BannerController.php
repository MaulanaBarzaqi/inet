<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
     function readAllBanners()
    {
        $banner = Banner::orderBy('created_at', 'desc')->get();

            return response()->json([
                    'message' => count($banner) > 0 ? 'Data found' : 'No banners',
                    'data' => $banner,
                ], 200);
    }
}
