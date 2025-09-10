<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // query dasar
        $query = User::with('region')->where('role', 'user');
        // cek jika ada parameter search
        if (request()->has('search') && !empty(request('search'))) {
            $search = request()->input('search');
            // search condition
            $query->where(function ($q) use ($search){
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhereHas('region', function ($qRegion) use ($search){
                        $qRegion->where('name', 'like', "%$search%");
                    });
            });
        }
        // final query
        $items = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.clients.index')->with([
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
    public function show(User $user)
    {
        // $item = User::with('region')->findOrFail($id);
        $regions = Region::all();
        
        return view('pages.clients.show')->with([
            'item' => $user,
            'regions' => $regions
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

     /**
     * set region resource from storage.
     */
    public function setRegion(Request $request, User $user)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id'
        ]);
        
        $user->region_id = $request->region_id;
        $user->save();

        return redirect()->route('user.index');

    }
}
