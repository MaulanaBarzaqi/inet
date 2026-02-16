<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use App\Models\NotificationLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PushNotification;

class NotificationController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }

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

            // Simpan log notifikasi
            NotificationLog::create([
                'target_type'  => $targetType,
                'target_id'    => ($targetType === 'all') ? null : ($request->user_id ?? $request->region_id),
                'category'     => 'general',
                'title'        => $title,
                'body'         => $body,
                'total_sent'   => $notifiableUsers->count(),
                'sent_by'      => auth()->id(),
                'data_payload' =>[
                        'target_name' => $message, // Contoh: "Pelanggan di Daerah: Sudirman"
                        'raw_target'  => $targetType
                ], 
            ]);

            return redirect()->back()->with('success', "Notifikasi berhasil dikirim ke {$notifiableUsers->count()} perangkat pada target: {$message}.");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim notifikasi: ' . $e->getMessage());
        }
    }


    /**
     * Display a listing of the notification reports.
     */
    // public function report(Request $request)
    // {   
    //     $query = NotificationLog::query();
    //     // Filter Search (Judul atau Isi Pesan)
    //     if ($request->filled('search')) {
    //         $query->where(function($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%')
    //               ->orWhere('body', 'like', '%' . $request->search . '%');
    //         });
    //     }
    //     // Filter Month (format: YYYY-MM)
    //     if ($request->filled('month')) {
    //         $query->whereMonth('created_at', date('m', strtotime($request->month)))
    //               ->whereYear('created_at', date('Y', strtotime($request->month)));
    //     }
    //     // Filter Week (format: YYYY-Www)
    //     if ($request->filled('week')) {
    //         // PHP strtotime bisa mengenali format "2026-W05"
    //         $query->whereBetween('created_at', [
    //             date('Y-m-d', strtotime($request->week)), 
    //             date('Y-m-d', strtotime($request->week . ' +6 days'))
    //         ]);
    //     }
    //     $logs = $query->latest()->paginate(10);

    //     return view('pages.notification.report', compact('logs'));
    // }
    /**
     * Remove the specified notification log from storage.
     */
    // Method privat agar tidak perlu menulis ulang logika filter
    private function applyFilter(Request $request)
    {
        $query = NotificationLog::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('body', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)))
                  ->whereYear('created_at', date('Y', strtotime($request->month)));
        }

        if ($request->filled('week')) {
            $query->whereBetween('created_at', [
                date('Y-m-d', strtotime($request->week)), 
                date('Y-m-d', strtotime($request->week . ' + 6 days'))
            ]);
        }

        return $query;
    }

    public function report(Request $request)
    {   
        $query = $this->applyFilter($request); // Panggil filter
        $logs = $query->latest()->paginate(10);

        return view('pages.notification.report', compact('logs'));
    }

    public function exportPdf(Request $request)
    {
        $query = $this->applyFilter($request); // Panggil filter yang sama
        $logs = $query->latest()->get(); // PDF biasanya ambil semua data tanpa pagination

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.notification.pdf_report', compact('logs'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Notifikasi_' . now()->format('Y-m-d') . '.pdf');
    }

    public function destroy($id)
    {
        try {
            $log = NotificationLog::findOrFail($id);
            $log->delete();

            return redirect()->route('notifications.report')->with('success', 'Log notifikasi berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus log: ' . $e->getMessage());
        }
    }
    
}
