<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stringable;

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
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $slugCounter = 1;
        // cek jika slug sudah ada di database
        while(Banner::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }
        // insert data
        $data = new Banner();
        $data->title = $request->title;
        $data->slug = $slug;
        $data->save();
        // image handling with auto increment
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $baseName = Str::slug($request->title);
            $imageName = $baseName . '.' . $extension;
            $imageCounter = 1;
            // cek jika nama file sudah ada di storage
            while (Storage::disk('public')->exists('assets/banner/' . $imageName)) {
                $imageName = $baseName . '(' . $imageCounter . ').' . $extension;
                $imageCounter++;
            }
            // simpan dengan nama unik
            $path = $request->file('image')->storeAs(
                'assets/banner',
                $imageName,
                'public'
            );
            // update database dengan path image
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
    public function edit(string $id)
    {
        $item = Banner::findOrFail($id);

        return view('pages.banner.edit')->with([
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, string $id)
    {
        $item = Banner::findOrFail($id);
       
        // generate unique slug jika title berubah
        if ($item->title != $request->title) {
            $baseSlug = Str::slug($request->title);
            $slug = $baseSlug;
            $slugCounter = 1;
            // Cek slug unique kecuali untuk record ini sendiri
            while (Banner::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $slugCounter;
                $slugCounter++;
            }
            $item->slug = $slug;
        }
        // update
        $item->title = $request->title;
        if ($request->hasFile('image')) {
            // hapus image lama jika ada
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            // generate nama file baru dengan auto increment
            $extension = $request->file('image')->getClientOriginalExtension();
            $baseName = Str::slug($request->title);
            $imageName = $baseName . '.' . $extension;
            $imageCounter = 1;
            // cek jika nama file sudah ada di storage
            while (Storage::disk('public')->exists('assets/banner/' . $imageName)) {
                $imageName = $baseName . '(' . $imageCounter . ').' . $extension;
                $imageCounter++;
            }
            // simpan file dengan nama unik
            $path = $request->file('image')->storeAs(
                'assets/banner',
                $imageName,
                'public'
            );
            $item->image = $path;
        }
        $item->save();
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            $item = Banner::findOrFail($id);
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $item->delete();
            return redirect()->route('banner.index');
       } catch (\Exception $e) {
        return redirect()->route('banner.index')
                ->with('error', 'Gagal menghapus banner: ' . $e->getMessage());
       }
    }
}
