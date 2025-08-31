<?php

namespace App\Http\Controllers;

use App\Helpers\InternetPackageHelper;
use App\Http\Requests\InternetPackage\StoreInternetPackageRequest;
use App\Http\Requests\InternetPackage\UpdateInternetPackageRequest;
use App\Models\InternetPackage;

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
        $slug = InternetPackageHelper::generateUniqueSlug($request->name);
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
        if ($request->hasFile('image')) {
            $path = InternetPackageHelper::handleImageUpload(
                $request->file('image'),
                $request->name
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
        if ($item->name != $request->name) {
            $item->slug = InternetPackageHelper::generateUniqueSlug($request->name, $id);
        }
        // update data
        $item->name = $request->name;
        $item->category = $request->category;
        $item->speed = $request->speed;
        $item->ideal_device = $request->ideal_device;
        $item->installation = $request->installation;
        $item->monthly_bill = $request->monthly_bill;
        // image handling
        if($request->hasFile('image')) {
            $path = InternetPackageHelper::handleImageUpload(
                $request->file('image'),
                $request->name,
                $item->image
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
        try {
            $item = InternetPackage::findOrFail($id);
            // hapus image pake helper
            InternetPackageHelper::deleteImage($item->image);
            $item->delete();

            return redirect()->route('internet-package.index');
        } catch (\Exception $e) {
            return redirect()->route('internet-package.index')
                 ->with('error', 'Gagal menghapus paket: ' . $e->getMessage());
        }
    }

}
