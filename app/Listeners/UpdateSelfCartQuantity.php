<?php

namespace App\Listeners;

use App\Events\SelfCartQuantityUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class UpdateSelfCartQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SelfCartQuantityUpdated $event): void
    {
        Broadcast::on('private-self-cart.' . Auth::user()->nis)->send();
        // $user = $event->user;
        // $cart = $event->cart;
        // broadcast(new SelfCartQuantityUpdated($user, $cart));
    }
}
