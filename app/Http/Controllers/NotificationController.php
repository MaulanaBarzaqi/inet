<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{   
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.notification.create');
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target_type' => 'required|in:all,user,region',
            'user_id' => 'required_if:target_type,user|exists:users,id',
            'region_id' => 'required_if:target_type,region|exists:regions,id',
        ]);

        try {
            $count = 0;
            $message = '';
            switch ($request->target_type) {
                case 'all':
                    $count = $this->notificationService->sendToAllUsers(
                        $request->title,
                        $request->body
                    );
                     $message = "Notifikasi berhasil dikirim ke {$count} pengguna";
                    break;

                case 'user':
                    $success = $this->notificationService->sendToUser(
                        $request->user_id,
                        $request->title,
                        $request->body
                    );
                    $count = $success ? 1:0;
                     $message = $success 
                        ? "Notifikasi berhasil dikirim ke pengguna" 
                        : "Gagal mengirim notifikasi ke pengguna";
                    break;

                case 'region':
                    $count = $this->notificationService->sendToRegion(
                        $request->region_id,
                        $request->title,
                        $request->body
                    );
                    $message = "Notifikasi berhasil dikirim ke {$count} pengguna di daerah tersebut";
                    break;
            }
             return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
             return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }
}
