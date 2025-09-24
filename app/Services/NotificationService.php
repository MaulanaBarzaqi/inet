<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
     /**
     * Kirim notifikasi ke semua user (kecuali admin)
     */
    public function sendToAllUsers($title, $body, $data = [])
    {
       $users = User::where('role', '!=', 'admin')
                      ->whereNotNull('fcm_token')
                      ->where('fcm_token', '!=', '')
                      ->get();
        $successCount = 0;
        foreach ($users as $user) {
            try {
                $user->notify(new CustomNotification($title, $body, $data));
                $successCount++;
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notifikasi ke user {$user->id}:" . $e->getMessage());
            }
        }
        return $successCount;
    }

     /**
     * Kirim notifikasi ke user tertentu
     */
    public function sendToUser($userId ,$title, $body, $data = [])
    {
        $user = User::where('id', $userId)
                ->where('role', '!=', 'admin')
                ->whereNotNull('fcm_token')
                ->where('fcm_token', '!=', '')
                ->first();
        if ($user) {
            try {
                $user->notify(new CustomNotification($userId ,$title, $body, $data = []));
                return true;
            } catch (\Exception $e) {
                 Log::error("Gagal mengirim notifikasi ke user {$userId}: " . $e->getMessage());
                return false;
            }
        }
        return false;
    }

      /**
     * Kirim notifikasi berdasarkan region ID
     */
    public function sendToRegion($regionId, $title, $body, $data = [])
    {
        $users = User::where('region_id', $regionId)
                       ->where('role', '!=', 'admin')
                       ->whereNotNull('fcm_token')
                       ->where('fcm_token', '!=', '')
                       ->get();

        $successCount = 0;
        foreach ($users as $user) {
            try {
                $user->notify(new CustomNotification($title, $body, $data));
                $successCount++;
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notifikasi ke user {$user->id} di region {$regionId}: " . $e->getMessage());
            }
        }
        return $successCount;
    }
}