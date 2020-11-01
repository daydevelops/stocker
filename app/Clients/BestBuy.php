<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{
    public function checkAvailability(Stock $stock): StockStatus
    {   
        $url =$this->endpoint($stock->sku);
        $results = Http::get($url)->json();
        return new StockStatus(
            $results['onlineAvailability'],
            $results['salePrice'] * 100 // to cents
        );
    }

    protected function endpoint($sku): string {
        $key = config('services.clients.bestBuy.apiKey');
        return "https://api.bestbuy.com/v1/products/".$sku.".json?apiKey=".$key;
    }
}
