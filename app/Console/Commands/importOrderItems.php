<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class importOrderItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importOrderItems';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $rowProduct = 1;
        $increment_id = 1;
        if (($handle = fopen("storage/app/order_products__prior.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 500)) !== FALSE) {
                $num = count($data);
                echo "$num fields in line $data[0], name: $data[1],departman_id: $data[3],   \n";
                if ($rowProduct > 1) {
                    // dd($data[1]);
                    $attributes = DB::table('product_flat')->where('product_id', $data[1])->get();
                    // dd($attributes);
                    foreach ($attributes as $attribute) {
                        $sku = $attribute -> sku;
                        $name = $attribute -> name;
                        $price = $attribute -> price;
                        $weight = $attribute -> weight;
                    }
                    echo "sku $sku, name: $name, price: $price, weight: $weight \n";
                    $now = Carbon::now();
                    DB::table('order_items')->insertOrIgnore([
                        'product_id' => $data[1],
                        'sku' => $sku,
                        'type' => 'simple',
                        'name' => $name,
                        'weight' => $weight,
                        'total_weight' => $weight,
                        'qty_ordered' => 1,
                        'qty_shipped' => 1,
                        'qty_invoiced' => 1,
                        'price' => $price,
                        'total' => $price,
                        'base_total' => $price,
                        'base_price' => $price,
                        'total_invoiced' => $price,
                        'base_total_invoiced' => $price,
                        'product_type' => 'Webkul\Product\Models\Product',
                        'order_id' => $data[0],
                        'additional' => '{"_token": "1221"}',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    $increment_id++;
                }
                $rowProduct++;
            }
            fclose($handle);
        }
    }
}
