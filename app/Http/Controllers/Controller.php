<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
    protected function user(): ?User
    {
        return auth()->user();
    }

    protected function clinicaId(): ?int
    {
        return auth()->user()?->clinica_id;
    }

    protected function hasRole(string ...$roles): bool
    {
        return in_array(auth()->user()?->rol, $roles, true);
    }
}
