<?php

namespace App\UseCases;

use App\Clients\StockStatus;
use App\Notifications\NewStockAvailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Stock;
use App\Models\User;

class TrackStock implements ShouldQueue
{

    use Dispatchable, SerializesModels;

    protected $status;
    protected $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function handle()
    {
        $this->checkAvailability();

        if ($this->stock->in_stock != $this->status->available || $this->stock->price != $this->status->price) {
            $this->refreshStock();
            $this->notifyUser();
            $this->recordHistory();
        }
    }

    public function checkAvailability()
    {
        $this->status = $this->stock->retailer->client()->checkAvailability($this->stock);
    }

    public function refreshStock()
    {
        $this->stock->update([
            'in_stock' => $this->status->available,
            'price' => $this->status->price
        ]);
    }

    public function notifyUser() {
        User::first()->notify(new NewStockAvailable($this->stock));
    }

    public function RecordHistory() {
        $this->stock->history()->create([
            'price' => $this->stock->price,
            'in_stock' => $this->stock->in_stock
        ]);
    }
}
