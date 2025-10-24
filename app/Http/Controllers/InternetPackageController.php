<?php

namespace App\Http\Controllers;

use App\Helpers\InternetPackageHelper;
use App\Http\Requests\InternetPackage\StoreInternetPackageRequest;
use App\Http\Requests\InternetPackage\UpdateInternetPackageRequest;
use App\Models\Category;
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
        $items = InternetPackage::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        if (request()->has('search')) {
            $search = request()->input('search');
            $items = InternetPackage::with('category')
                ->where('name', 'like', "%$search%")
                ->orWhereHas('category', function($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }

        return view('pages.internet-package.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Category::orderBy('name')->get();

        return view('pages.internet-package.create')->with([
            'categories' => $categories
        ]);
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
        $data->category_id = $request->category_id;
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
     * Show the form for editing the specified resource.
     */
    public function edit(InternetPackage $internetPackage)
    {
        $categories = Category::orderBy('name')->get();

        return view('pages.internet-package.edit')->with([
            'item' => $internetPackage,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInternetPackageRequest $request, InternetPackage $internetPackage)
    {   
        $item = $internetPackage;

        // generate unique slug(jika nama berubah)
        if ($item->name != $request->name) {
            $item->slug = InternetPackageHelper::generateUniqueSlug($request->name, $item->id);
        }
        // update data
        $item->name = $request->name;
        $item->category_id = $request->category_id;
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
    public function destroy(InternetPackage $internetPackage)
    {
        try {
            $item = $internetPackage;
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
