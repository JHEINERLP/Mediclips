<?php

namespace App\Services;

use App\Mail\UserWelcomeMail;
use App\Models\Clinica;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserInvitationService
{
    public static function sendNotification(User $user, Clinica $clinica, bool $isSelfRegistration = false): void
    {
        Mail::to($user->email)->send(new UserWelcomeMail(
            user: $user,
            clinica: $clinica,
            isSelfRegistration: $isSelfRegistration,
        ));
    }

    public static function resendNotification(User $user): void
    {
        $clinica = $user->clinica ?? Clinica::findOrFail($user->clinica_id);
        self::sendNotification($user, $clinica);
    }
}
