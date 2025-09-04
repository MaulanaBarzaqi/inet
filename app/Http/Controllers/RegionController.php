<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Helpers\RegionHelper;
use App\Http\Requests\Region\StoreRegionRequest;
use App\Http\Requests\Region\UpdateRegionRequest;

class RegionController extends Controller
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
        $items = Region::orderBy('created_at', 'desc');
         if (request()->has('search')) {
            $search = request()->input('search');
            $items = Region::where('name', 'like', "%$search%");
        }
        $items = $items->paginate(5)->withQueryString();

        return view('pages.region.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.region.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        // generate unique slug
        $slug = RegionHelper::generateUniqueSlug($request->name);
        // insert data
        $data = new Region();
        $data->name = $request->name;
        $data->slug = $slug;
        $data->location = $request->location;
        $data->description = $request->description;
        $data->save();
        // image handling
        if ($request->hasFile('image')) {
            $path = RegionHelper::handleImageUpload(
                $request->file('image'),
                $request->name
            );
            $data->image = $path;
            $data->save();
        }

        return redirect()->route('region.index');
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
    public function edit(Region $region)
    {
        return view('pages.region.edit')->with([
            'item' => $region
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegionRequest $request, Region $region)
    {
        $item = $region;
       
        // generate unique slug jika name berubah
        if ($item->name != $request->name) {
            $item->slug = RegionHelper::generateUniqueSlug($request->name, $item->id);
        }
        // update
        $item->name = $request->name;
        $item->location = $request->location;
        $item->description = $request->description;
        // image handling
        if ($request->hasFile('image')) {
            $path = RegionHelper::handleImageUpload(
                $request->file('image'),
                $request->name,
                $item->image 
            );
            $item->image = $path;
        }
        $item->save();
        return redirect()->route('region.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Region $region)
    {
         try {
            $item = $region;
            // hapus image pake helper
            RegionHelper::deleteImage($item->image);
            $item->delete();
            return redirect()->route('region.index');

       } catch (\Exception $e) {
        return redirect()->route('region.index')
                ->with('error', 'Gagal menghapus region: ' . $e->getMessage());
       }
    }
}
