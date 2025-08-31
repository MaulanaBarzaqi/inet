<?php

namespace App\Http\Controllers;

use App\Models\InternetInstallation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternetInstallationController extends Controller
{   
     public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = InternetInstallation::with(['internetPackage', 'user'])->orderBy('created_at', 'desc')->paginate(5);
        if (request()->has('search')) {
            $search = request()->input('search');
            $items = InternetInstallation::where('name', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%")
                ->with(['internetPackage', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
        return view('pages.internet-installation.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $item = InternetInstallation::with(['internetPackage', 'user'])->findOrFail($id);
        return view('pages.internet-installation.show')->with([
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function setStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $item = InternetInstallation::findOrFail($id);
        $item->status = $request->status;

        $item->save();

        return redirect()->route('internet-installation.index');
    }
}
