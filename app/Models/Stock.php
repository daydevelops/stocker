<?php

namespace App\Models;

use App\Events\StockUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'in_stock' => "boolean"
    ];

    protected $dispatchesEvents = [
        'updated' => StockUpdated::class
    ];

    public function track()
    {
        $status = $this->retailer->client()->checkAvailability($this);
        if ($this->in_stock != $status->available || $this->price != $status->price) {
            $this->update([
                'in_stock' => $status->available,
                'price' => $status->price
            ]);
        }
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
