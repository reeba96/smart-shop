<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductImage;


class importImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importImages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import images from ewe';

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
        DB::table('product_images')->whereRaw('1=1')->delete();

        $xml_string = Storage::disk('local')->get('data\ewe.xml');

        $array = XmlToArray::convert($xml_string);
      
        $products = collect($array['product']);


        $bar = $this->output->createProgressBar(count($products));
        $bar->start();


        foreach($products as $xml_product) {

            if ( isset($xml_product['images'] ) ){

                $product = Product::where('sku',strtolower($xml_product['id']))->first();
                if ($product){
                    foreach($xml_product['images'] as $image){

                        if( is_array($image)) {
                            foreach($image as $image_item){
                                $this->saveImage($product->id,$image_item);
                            }
                        }
                        else{
                            $this->saveImage($product->id,$image);
                        }
                        
                    }
                }
            } 
            $bar->advance();
        }
        $bar->finish();
    }

    public function saveImage($product_id, $image){

        $img = file_get_contents($image);

        $image_arr = explode('/',$image);
        $filename = end($image_arr);
        $path = 'product/'.$product_id.'/'.$filename;

        $product_image = new ProductImage;
        $product_image->product_id = $product_id;
        $product_image->path = $path;

        $product_image->save();
        
        Storage::put($path, $img);

    }
}
