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
    protected $signature = 'command:importImages {params?}';

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
        if ($this->argument('params') == 'fresh'){
            DB::table('product_images')->whereRaw('1=1')->delete();
        }

        
       // $xml_string = Storage::disk('local')->get('data\ewe.xml');

     //   $array = XmlToArray::convert($xml_string);
     //   $products = collect($array['product']);

        $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser( ltrim(Storage::disk('local')->url('app/data/ewe.xml'),'/' ) );
        $i = 0;
        while ($node = $streamer->getNode()) {
            
            $simpleXmlNode = simplexml_load_string($node);

            $product = XmlToArray::convert($node);

            if ( empty($product['ean'])) {
                //   dump($product); exit;
                $product['ean'] = $product['id'];
            }
            $product_sku = $product['ean'];

            //$product_image = (string)$simpleXmlNode->images;
            //$bar = $this->output->createProgressBar(count($products));
            //$bar->start();
            echo $i++.' '.$product_sku ."\n";
         
            if ( isset($product['images']['image'])  ){
              
                $db_product = Product::where('sku',strtolower($product_sku))->first();

                if ($db_product){
                    if ( is_array( $product['images']['image']) ){
                        foreach( $product['images']['image'] as $key => $image_item){
                            $this->saveImage($db_product->id,(string)$image_item);
                        }
                    }
                    else{
                        $this->saveImage($db_product->id,$product['images']['image']);
                    }
                }
            } 
         //   $bar->advance();
        }
        //$bar->finish();
    }

    public function saveImage($product_id, $image){

        $image_arr = explode('/',$image);
        $filename = end($image_arr);
        $path = 'product/'.$product_id.'/'.$filename;

        $product_image = ProductImage::where('product_id',$product_id)->where('path',$path)->first();
        if($product_image) {
            $found = true;

        }
        else $found = false;
        if ( $product_id == 75540 )
            dump(['image found' => $found,'product_id' => $product_id, 'path' => $path]);
        if ($this->argument('params') == 'fresh' || !$product_image ) {
            $img = file_get_contents($image);

            dump( $path );
            $product_image = new ProductImage;
            $product_image->product_id = $product_id;
            $product_image->path = $path;
            $product_image->save();
            
            Storage::put($path, $img);
        }
      
    }
}
