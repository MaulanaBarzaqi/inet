<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternetInstallation\StoreInternetInstallationRequest;
use App\Models\InternetInstallation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InternetInstallationController extends Controller
{
    public function create(StoreInternetInstallationRequest $request)
    {  
         $existingInstallation = InternetInstallation::where('user_id', $request->user()->id)->first();

         if($existingInstallation) {
            return response()->json([
                'message' => 'anda sudah memiliki pemasangan internet',
                'data' => $existingInstallation,
            ], 422);
         }

         DB::beginTransaction();
         try {
              $internetInstallation = InternetInstallation::create([
                'name' => $request->name,
                'nik' => $request->nik,
                'phone' => $request->phone,
                'address' => $request->address,
                'user_id' => $request->user()->id,
                'internet_package_id' => (int) $request->internet_package_id,
            ]);
              // Update internet_installation_id di users
            $user = User::find($request->user()->id);
            $user->update([
                'internet_installation_id' => $internetInstallation->id
            ]);

            DB::commit();
            return response()->json([
               'message' => 'Internet installation created successfully',
               'data' => $internetInstallation,
            ], 201);
         } catch (\Exception $e) {
             DB::rollBack();
            
            return response()->json([
                'message' => 'Failed to create internet installation',
                'error' => $e->getMessage()
            ], 500);
         }
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