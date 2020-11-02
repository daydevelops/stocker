<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track all products';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $products = Product::all();
        // start progress bar
        $this->output->progressStart($products->count());

        Product::all()->each(function ($product) {
            $product->track();
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $data = Product::leftJoin('stocks','stocks.product_id','products.id')
        ->get(['name','in_stock','price','url']);

        $this->table(
            ['Name','Available','Price','URL'],
            $data
        );
    }
}
