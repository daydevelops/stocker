<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

interface Client
{
    public function checkAvailability(Stock $stock): StockStatus;
}
