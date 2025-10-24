<?php

namespace App\Http\Controllers;

use App\Models\InternetInstallation;
use App\Notifications\PushNotification;
use Illuminate\Http\Request;

class InternetInstallationController extends Controller
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
        $query = InternetInstallation::with(['internetPackage', 'user']);

        if (request()->has('search') && !empty(request('search'))) {
            $search = request()->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.internet-installation.index')->with([
            'items' => $items
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(InternetInstallation $internetInstallation)
    {
        
        return view('pages.internet-installation.show')->with([
            'item' => $internetInstallation
        ]);
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternetInstallation $internetInstallation)
    {
        $internetInstallation->delete();

        return redirect()->route('internet-installation.index');
    }


     /**
     * set status resource from storage.
     */
    public function setStatus(Request $request, InternetInstallation $internetInstallation)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $item = $internetInstallation;
        $oldStatus = $item->status;
        $newStatus = $request->status;

        $item->status = $newStatus;
        
        if($oldStatus != $newStatus) {
            $item->save();

            $user = $item->user;

            if ($user && $user->fcm_token) {
                $title = 'Status Pemasangan internet sudah diperbaharui';

                switch ($newStatus) {
                    case 'approved':
                        $body = 'Selamat! Permintaan pemasangan Anda telah DISETUJUI. Silakan cek detailnya.';
                        break;
                    case 'rejected':
                        $body = 'Mohon maaf. Permintaan pemasangan Anda telah DITOLAK. Silakan cek detailnya.';
                        break;
                    case 'pending':
                        $body = 'Status pemasangan Anda dikembalikan menjadi PENDING. Silakan cek detailnya.';
                        break;
                    default:
                         $body = "Status pemasangan Anda diubah menjadi {$newStatus}. Cek sekarang!";
                }
                 $dataPayload = [
                    'type' => 'installation_status_update', 
                    'installation_id' => (string)$item->id,
                    'new_status' => $newStatus,
                ];
                $user->notify(new PushNotification($title, $body, $dataPayload));
            } else {
                $item->save();
            }
        }

        return redirect()->route('internet-installation.index');
    }
}
