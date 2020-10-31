<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'in_stock' => "boolean"
    ];

    public function track() {
        // hit API for retailer
        // fetch updated info on the product
        // update our db

        switch ($this->retailer->name) {
            case 'bestbuy':
                $results = Http::get('http://foo.test')->json();
                $this->update([
                    'in_stock' => $results['available'],
                    'price' => $results['price']
                ]);
                break;
            
            default:
                # code...
                break;
        }
    }

    public function retailer() {
        return $this->belongsTo(Retailer::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
