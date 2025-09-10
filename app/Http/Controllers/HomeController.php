<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\InternetInstallation;
use App\Models\InternetPackage;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $admin = User::where('role', 'admin')->first();
        $internetPackages = InternetPackage::count();
        $banners = Banner::count();
        $installationCount = InternetInstallation::count();;
        $installations = InternetInstallation::orderBy('created_at', 'desc')->take(5)->get();
        $approved = InternetInstallation::where('status', 'approved')->count();
        $pending = InternetInstallation::where('status', 'pending')->count();
        $rejected = InternetInstallation::where('status', 'rejected')->count();

        return view('home')->with([
            'admin' => $admin,
            'internetPackages' => $internetPackages,
            'banners' => $banners,
            'installations' => $installations,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,
            'installationCount' => $installationCount,
        ]);
    }
}
