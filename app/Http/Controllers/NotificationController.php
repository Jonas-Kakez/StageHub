<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->appNotifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(AppNotification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['lu' => true]);

        if ($notification->lien) {
            return redirect($notification->lien);
        }

        return back();
    }

    public function markAllRead(Request $request)
    {
        $request->user()->appNotifications()->update(['lu' => true]);

        return back()->with('success', 'Toutes les notifications marquées comme lues.');
    }
}
