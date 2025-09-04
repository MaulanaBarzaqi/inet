<?php

namespace App\Http\Controllers;

use App\Helpers\BannerHelper;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Models\Banner;

class BannerController extends Controller
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
        $items = Banner::orderBy('created_at', 'desc');        
        
        if (request()->has('search')) {
            $search = request()->input('search');
            $items = Banner::where('title', 'like', "%$search%");
        }
        $items = $items->paginate(5)->withQueryString();

        return view('pages.banner.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('pages.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        // generate unique slug
        $slug = BannerHelper::generateUniqueSlug($request->title);
        // insert data
        $data = new Banner();
        $data->title = $request->title;
        $data->slug = $slug;
        $data->save();
        // image handling
        if ($request->hasFile('image')) {
            $path = BannerHelper::handleImageUpload(
                $request->file('image'),
                $request->title
            );
            $data->image = $path;
            $data->save();
        }

        return redirect()->route('banner.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {   

        return view('pages.banner.edit')->with([
            'item' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $item = $banner;
        // generate unique slug jika title berubah
        if ($item->title != $request->title) {
            $item->slug = BannerHelper::generateUniqueSlug($request->title, $item->id);
        }
        // update
        $item->title = $request->title;
        // image handling
        if ($request->hasFile('image')) {
            $path = BannerHelper::handleImageUpload(
                $request->file('image'),
                $request->title,
                $item->image 
            );
            $item->image = $path;
        }
        $item->save();
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
       try {
            $item = $banner;
            // hapus image pake helper
            BannerHelper::deleteImage($item->image);
            $item->delete();
            return redirect()->route('banner.index');

       } catch (\Exception $e) {
        return redirect()->route('banner.index')
                ->with('error', 'Gagal menghapus banner: ' . $e->getMessage());
       }
    }
}
