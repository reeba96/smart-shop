<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductInventory;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Core\Models\Locale;

use Webkul\Product\Models\ProductFlat;

use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class importStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importStock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stock to dB';

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
     * @return mixed
     */
    public function handle()
    {
        //
        echo "Import Inventories to 'default',  inventory_id = 1 \n";
   
        $url='http://api.ewe.rs/share/backend/?user=go2networx&secretcode=58b30&attributes=0&images=0';

        $ch =curl_init();

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        $return = curl_exec ($ch);
        $info = curl_getinfo($ch);
        Storage::disk('local')->put('data\ewe_simple.xml', $return);
        curl_close ($ch);

        $inventory_source_id = 1;

        $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser( ltrim(Storage::disk('local')->url('app/data/ewe_simple.xml'),'/' ) );
        $i = 0;
    
        while ($node = $streamer->getNode()) {
           
            $product = XmlToArray::convert($node);
            $db_product = Product::where('ewe_product_id',$product['id'])->first();

            if ( $db_product) {
                $qty = $product['stock'] - $product['stockReservation'];
                ProductInventory::updateOrCreate(
                    [ 'product_id' => $db_product->id ],
                    [  'qty' => $qty,
                       'inventory_source_id' => $inventory_source_id
                    ]);

                 //switch off the product on QTY=0                               ['attribute_id' => '8',/*'

                if ( $qty == 0 ){
                    ProductAttributeValue::where('product_id',$db_product->id)->where('attribute_id',8)->update(['boolean_value'=>0]);
                    ProductFlat::where('id',$db_product->id)->update(['status'=> 0]);
                }
                else{
                    ProductAttributeValue::where('product_id',$db_product->id)->where('attribute_id',8)->update(['boolean_value'=>1]);
                    ProductFlat::where('id',$db_product->id)->update(['status'=> 1]);
                }
            }
        }
    }
}