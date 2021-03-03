<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductFlat;
use Webkul\Attribute\Models\AttributeFamily;
use Webkul\Attribute\Models\AttributeGroup;
use Webkul\Attribute\Models\AttributeOptionTranslation;
use Webkul\Attribute\Models\AttributeOption;
use Webkul\Attribute\Models\Attribute;
use Webkul\Product\Models\ProductAttributeValue;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class importManufacturer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importManufacturer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add manufacturer option to the product flat table';

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
        $attribute_id = 25; //manufacturer

        //
        // $ewe_path = 'http://resource.ewe.rs/manufacturers/';
        // //inport logos
        // $pavs = ProductAttributeValue::where('attribute_id',$attribute_id )->pluck('id','text_value');
        // $path = 'manufacturer/';

        $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser( ltrim(Storage::disk('local')->url('app/data/ewe.xml'),'/' ) );
        $i = 0;
        while ($node = $streamer->getNode()) {

        $simpleXmlNode = simplexml_load_string($node);

        $getManufacturers = (string)$simpleXmlNode->manufacturer;
        $pavs = collect([$getManufacturers]);

        if(!Schema::hasColumn('product_flat', 'manufacturer')){

            Schema::table('product_flat', function (Blueprint $table) {
                $table->string('manufacturer')->nullable();
            });

        };

        $attribute_id = 25; //manufacturer
        $bar = $this->output->createProgressBar(count($pavs));
        $bar->start();
        foreach( $pavs as $pav){
            $pavArray = collect([$pav]);
            $update = $pavArray;
            ProductFlat::where('product_id',$pavArray)->update($update);
            $bar->advance();
        }
        $bar->finish();

    }
}

}

