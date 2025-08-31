<?php

namespace App\Http\Controllers;

use App\Http\Requests\InternetPackage\StoreInternetPackageRequest;
use App\Http\Requests\InternetPackage\UpdateInternetPackageRequest;
use App\Models\InternetPackage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InternetPackageController extends Controller
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

        $items = InternetPackage::orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();
        if (request()->has('search')) {
            $search = request()->input('search');
            $items = InternetPackage::where('name', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('pages.paket-internet.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        return view('pages.paket-internet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreInternetPackageRequest $request)
    {
        // generate unique slug
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $slugCounter = 1;
        // cek jika slug sudah ada di database
        while(InternetPackage::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $slugCounter;
            $slugCounter++;
        }
        // insert data
        $data = new InternetPackage();
        $data->name = $request->name;
        $data->slug = $slug;
        $data->category = $request->category;
        $data->speed = $request->speed;
        $data->ideal_device = $request->ideal_device;
        $data->installation = $request->installation;
        $data->monthly_bill = $request->monthly_bill;
        $data->save();
        // image handling with auto increment numbering
        if($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $baseName = Str::slug($request->name);
            $imageName = $baseName . '.' . $extension;
            $imageCounter = 1;

            // cek jika file dengan nama sudah ada di storage
            while (Storage::disk('public')->exists('assets/internet-package/' . $imageName)) {
                $imageName = $baseName . '(' . $imageCounter . ').' . $extension;
                $imageCounter++;
            }
            // simpan file dengan nama unik
            $path = $request->file('image')->storeAs(
                'assets/internet-package',
                $imageName,
                'public'
            );
            // update database dengan path image
            $data->image = $path;
            $data->save();
        }
        return redirect()->route('internet-package.index');
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
        $item = InternetPackage::findOrFail($id);

        return view('pages.paket-internet.edit')->with([
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInternetPackageRequest $request, string $id)
    {   
        $item = InternetPackage::findOrFail($id);

        // generate unique slug(jika nama berubah)
        if($item->name != $request->name) {
            $baseSlug = Str::slug($request->name);
            $slug = $baseSlug;
            $slugCounter = 1;
            // cek slug unique kecuali untuk record ini sendiri
            while(InternetPackage::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $baseSlug . '-' . $slugCounter;
                $slugCounter++;
            }
            $item->slug = $slug;
        }
        // update data
        $item->name = $request->name;
        $item->category = $request->category;
        $item->speed = $request->speed;
        $item->ideal_device = $request->ideal_device;
        $item->installation = $request->installation;
        $item->monthly_bill = $request->monthly_bill;
        // image handling
        if ($request->hasFile('image')) {
            // hapus image jika ada
            if($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            // generate new name file with auto increment
            $extension = $request->file('image')->getClientOriginalExtension();
            $baseName = Str::slug($request->name);
            $imageName = $baseName . '.' . $extension;
            $imageCounter = 1;
            // cek jika file dengan nama sudah ada di storage
            while(Storage::disk('public')->exists('assets/internet-package/' . $imageName)) {
                $imageName = $baseName . '(' . $imageCounter . ').' . $extension;
                $imageCounter++;
            }
            // simpan file dengan nama unik
            $path = $request->file('image')->storeAs(
                'assets/internet-package',
                $imageName,
                'public'
            );
            $item->image = $path;
        }
        $item->save();
        return redirect()->route('internet-package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = InternetPackage::findOrFail($id);
        try {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $item->delete();
            return redirect()->route('internet-package.index');
        } catch (\Exception $e) {
            return redirect()->route('internet-package.index')
                 ->with('error', 'Gagal menghapus paket: ' . $e->getMessage());
        }
    }

}
