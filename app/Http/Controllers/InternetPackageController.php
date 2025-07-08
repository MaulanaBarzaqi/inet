<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InternetPackageRequest;
use App\Models\InternetPackage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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

        $items = InternetPackage::orderBy('created_at', 'desc')->paginate(5);
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
    public function store( Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'speed' => 'required|max:255',
            'ideal_device' => 'required|max:255',
            'installation' => 'required|integer',
            'monthly_bill' => 'required|integer',
        ];

        if($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('internet-package.create')
                ->withInput()
                ->withErrors($validator);
        }
        // insert data
        $data = new InternetPackage();
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->category = $request->category;
        $data->speed = $request->speed;
        $data->ideal_device = $request->ideal_device;
        $data->installation = $request->installation;
        $data->monthly_bill = $request->monthly_bill;
        $data->save();

        if ($request->image != "") {
            $imageName = Str::slug($request->name) . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')->storeAs('assets/internet-package', $imageName, 'public');
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
    public function update(Request $request, string $id)
    {   
        $item = InternetPackage::findOrFail($id);

        $rules = [
            'name' => 'required|max:255',
            'category' => 'required|max:255',
            'speed' => 'required|max:255',
            'ideal_device' => 'required|max:255',
            'installation' => 'required|integer',
            'monthly_bill' => 'required|integer',
        ];

        if($request->image != "") {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('internet-package.edit', $item->id)
                ->withInput()
                ->withErrors($validator);
        }
        // update data
        $item->name = $request->name;
        $item->slug = Str::slug($request->name);
        $item->category = $request->category;
        $item->speed = $request->speed;
        $item->ideal_device = $request->ideal_device;
        $item->installation = $request->installation;
        $item->monthly_bill = $request->monthly_bill;
        $item->save();

        if ($request->image != "") {
            // old image
            File::delete(public_path('images/internet-package/' . $item->image));
            // store new image
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            $image->move(public_path('images/internet-package'), $imageName);
            $item->image = $imageName;
            $item->save();
        }

        return redirect()->route('internet-package.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = InternetPackage::findOrFail($id);
        $item->delete();

        // InternetImage::where('internet_package_id', $id)->delete();

        return redirect()->route('internet-package.index');
    }

}
