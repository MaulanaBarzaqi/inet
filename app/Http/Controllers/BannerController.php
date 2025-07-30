<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $items = Banner::orderBy('created_at', 'desc')
                ->paginate(5)
                ->withQueryString();
             if (request()->has('search')) {
            $search = request()->input('search');
            $items = Banner::where('title', 'like', "%$search%")
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
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
    public function store(Request $request)
    {
         $rules = [
            'title' => 'required|max:255',
        ];

        if($request->image != "") {
            $rules['image'] = 'image|mimes:jpg,jpeg,png|dimensions:width=1000,height=400';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('banner.create')
                ->withInput()
                ->withErrors($validator);
        }
        // insert data
        $data = new Banner();
        $data->title = $request->title;
        $data->slug = Str::slug($request->title);
        $data->save();
        // image
        if ($request->image != "") {
            $imageName = Str::slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();

            $path = $request->file('image')->storeAs('assets/banner', $imageName, 'public');
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
    public function update(Request $request, string $id)
    {
        $item = Banner::findOrFail($id);
         $rules = [
            'title' => 'required|max:255',
        ];

        if($request->image != "") {
            $rules['image'] = 'image|mimes:jpg,jpeg,png|dimensions:width=1000,height=400';
        }
         $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('banner.edit')
                ->withInput()
                ->withErrors($validator);
        }
        // insert data
        $item = new Banner();
        $item->title = $request->title;
        $item->slug = Str::slug($request->title);
        $item->save();
        // image
        if ($request->image != "") {
              // old image
            if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
            // storage new image
            $imageName = Str::slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('assets/banner', $imageName, 'public');
            $item->image = $path;
            $item->save();
        }

        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Banner::findOrFail($id);
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return redirect()->route('banner.index');
    }
}
