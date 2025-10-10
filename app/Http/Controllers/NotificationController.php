<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PushNotification;

class NotificationController extends Controller
{   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
          $regions = \App\Models\Region::all();
          $users = \App\Models\User::where('role', 'user')->get();

        return view('pages.notification.create', compact('regions', 'users'));
    }

     /**
     * Menangani logika pengiriman notifikasi dari form admin.
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target_type' => 'required|in:all,user,region',
            'user_id' => 'required_if:target_type,user|nullable|exists:users,id',
            'region_id' => 'required_if:target_type,region|nullable|exists:regions,id',
        ]);

         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $title = $request->title;
        $body = $request->body;
        $targetType = $request->target_type;
        $notifiableUsers = collect();
        $message = '';
        try {
            if ($targetType === 'all'){
                $notifiableUsers = User::byRole('user')
                    ->withValidFcmToken()
                    ->get();
                    $message = "semua pelanggan";
            }
            elseif ($targetType === 'user' && $request->user_id) {
                  $user = User::withValidFcmToken()
                    ->find($request->user_id);
                if ($user) {
                    $notifiableUsers = collect([$user]);
                    $message = "Pelanggan: {$user->name}";
                } else {
                    return redirect()->back()->with('error', 'Pelanggan tidak ditemukan atau tidak memiliki token FCM.');
                }
            }
            elseif ($targetType === 'region' && $request->region_id) {
                  $regionId = $request->region_id;
                  $notifiableUsers = User::byRole('user')
                      ->byRegion($regionId)
                      ->withValidFcmToken()
                      ->get();
                  $regionName = Region::find($regionId)?->name ?? 'Daerah tidak dikenal';
                  $message = "Pelanggan di Daerah: {$regionName}";
            }
            Notification::send($notifiableUsers, new PushNotification($title, $body));

            return redirect()->back()->with('success', "Notifikasi berhasil dikirim ke {$notifiableUsers->count()} perangkat pada target: {$message}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }
}
