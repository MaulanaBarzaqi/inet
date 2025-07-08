<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InternetInstallation;
use Illuminate\Http\Request;

class InternetInstallationController extends Controller
{
    function readAll()
    {
        $internetInstallation = InternetInstallation::with(['internetPackage','user'])->get();

        return response()->json([
            'data' => $internetInstallation,
        ], 200);
    }
// response create dan response get all tidak sama :)
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'internet_package_id' => 'required|exists:internet_packages,id',
        ]);

        $internetInstallation = InternetInstallation::create([
            'name' => $validated['name'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'user_id' => $request->user()->id, // Assuming the user is authenticated
            'internet_package_id' => $validated['internet_package_id'],
        ]);

        return response()->json([
            'message' => 'Internet installation created successfully',
            'data' => $internetInstallation,
        ], 201);
    }
}
