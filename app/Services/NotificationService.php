<?php

namespace App\Services;

use App\Models\AppNotification;
use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public static function send(User $user, string $type, string $titre, string $message, ?string $lien = null): void
    {
        AppNotification::create([
            'user_id' => $user->id,
            'type' => $type,
            'titre' => $titre,
            'message' => $message,
            'lien' => $lien,
        ]);

        $user->notify(new GenericNotification($titre, $message, $lien));
    }

    public static function sendToMany(array $users, string $type, string $titre, string $message, ?string $lien = null): void
    {
        foreach ($users as $user) {
            self::send($user, $type, $titre, $message, $lien);
        }
    }
}
