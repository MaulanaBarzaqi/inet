<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternetInstallation\StoreInternetInstallationRequest;
use App\Models\InternetInstallation;

class InternetInstallationController extends Controller
{
    function readAll()
    {
        $internetInstallation = InternetInstallation::with(['internetPackage','user'])->get();

        return response()->json([
            'data' => $internetInstallation,
        ], 200);
    }

    public function create(StoreInternetInstallationRequest $request)
    {   // Cek jika user sudah punya installation
         $existingInstallation = InternetInstallation::where('user_id', $request->user()->id)->first();
         if ($existingInstallation) {
            return response()->json([
                'message' => 'Anda sudah memiliki pemasangan internet',
                'data' => $existingInstallation,
        ], 422);
    }
        $internetInstallation = InternetInstallation::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $request->user()->id, // Assuming the user is authenticated
            'internet_package_id' =>(int) $request->internet_package_id,
        ]);

        return response()->json([
            'message' => 'Internet installation created successfully',
            'data' => $internetInstallation,
        ], 201);
    }

    public function readByUser($id)
    {
        $internetInstallation = InternetInstallation::with(['internetPackage', 'user'])
            ->where('user_id', $id)
            ->first();

        if ($internetInstallation === null) {
            return response()->json([
                'message' => 'data not found',
                'data' => null,
            ], 404);
        }
        return response()->json([
            'data' => $internetInstallation,
        ], 200);
    }
}