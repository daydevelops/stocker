<?php

namespace App\Models;

use App\Events\StockUpdated;
use App\UseCases\TrackStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'in_stock' => "boolean"
    ];

    public function track()
    {
        TrackStock::dispatch($this);
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
