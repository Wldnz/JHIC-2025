<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('self-cart.{userNis}', function (User $user, string $userNis) {
    return $user->nis === $userNis;
});
