<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('post')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notifications', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notif = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->update(['is_read' => true]);

        return back();
    }

    // Tambahkan method untuk hapus semua notifikasi
    public function clearAll()
    {
        // Hapus semua notifikasi user yang login
        Notification::where('user_id', Auth::id())->delete();

        // Redirect kembali dengan flash message
        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}