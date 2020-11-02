<?php

namespace App\Listeners;

use App\Events\StockUpdated;
use App\Notifications\NewStockAvailable;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockUpdatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StockUpdated  $event
     * @return void
     */
    public function handle(StockUpdated $event)
    {
        $event->stock->history()->create([
            'price' => $event->stock->price,
            'in_stock' => $event->stock->in_stock
        ]);
        User::first()->notify(new NewStockAvailable($event->stock));
    }
}
