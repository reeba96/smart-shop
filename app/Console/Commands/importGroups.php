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

class importGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importGroups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add group options for selected attribute groups';

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
        $codes = ['broj_jezgara_procesora_intel_procesori','tip_memorije_serverske-memorije','kapacitet_serverske-memorije'];

        $attributes = Attribute::whereIn('code',$codes)->get();
        $lg = 'sr';
        $fields = [];
        $attribute_option_array = [];
        foreach ($attributes as $attribute){

            $attribute_id = $attribute->id;
     //       dump(['attribute_id'=> $attribute_id]);
            $pavs = ProductAttributeValue::where('attribute_id',$attribute_id )->get();

            $group_options = array_keys($pavs->pluck('id','text_value')->toArray());
    //dd($group_options);
            $i = 1;
            foreach( $group_options as $key => $option){
                if (empty($option))
                    continue;

           //     dump([ 'key' => $key, 'option' => $option]);
                $attribute_option = AttributeOption::firstOrCreate(
                    ['admin_name' => $option, 'attribute_id' => $attribute_id],
                    ['sort_order' => $i++]
                );

                $attribute_option_array[$option] = $attribute_option->id;

   //     dump(['$attribute_option->id' => $attribute_option->id]);



      //  dump(  ['attribute_option_id' => $attribute_option->id,'locale' => $lg], [ 'label'=> $option]);

                $attribute_option_translation = AttributeOptionTranslation::firstOrCreate(
                    ['attribute_option_id' => $attribute_option->id,'locale' => $lg],
                    ['label'=> $option]
                );

                    /*  DB::table('attribute_options')->insertGetId([
                            'admin_name' => $option,
                            'sort_order' => $i++,
                            'attribute_id' => $attribute_id
                        ]);*/

                if(!Schema::hasColumn('product_flat', $attribute->code)){

                    Schema::table('product_flat', function (Blueprint $table) use($attribute) {
                        $table->integer($attribute->code)->nullable();
                        $table->string($attribute->code.'_label')->nullable();
                    });

                };


            }
            if ( !empty($group_options)){ //update attribute to select type
                Attribute::whereId($attribute_id)->update(['type' => 'select','is_filterable' => 1 ]);
            }
         //   dump($group_options);
         dump($attribute_option_array);

            foreach( $pavs as $pav){
                if ( !empty($pav->text_value)){
                    dump(['product_id' => $pav->product_id,
                        'text_value' => $pav->text_value,
                        'tran' => $attribute_option_array[$pav->text_value]]);

                    $integer_value =  $attribute_option_array[$pav->text_value];
                    $update = [ //'text_value' => $pav->text_value,
                                'integer_value' => $integer_value ];

               //     ProductAttributeValue::whereId($pav->id)->update($update);

                    $code = ProductAttributeValue::whereId($pav->id)->first()->attribute->code;
                    if ($code){
                        $update = [$code => $integer_value, $code.'_label' =>  $pav->text_value];
                        ProductFlat::where('product_id',$pav->product_id)->update($update);
                        dump(['update' => $update,'product_id'=> $pav->product_id]);
                    }

                }



            }

            //update product_flat table
            //   $attribute_options = AttributeOption::where('attribute_id', $attribute_id)->get();
            //dump($attibute_options->toArray());
            $update = [];
            foreach ($pavs as $pav) {

                $update[$pav->attribute_id] = AttributeOption::where('attribute_id', $pav->attribute_id)->first()->admin_name; //todo átírni attribute translation-ra
                //ProductFlat::whereId($pav->id)->update(['type' => 'select','is_filterable' => 1 ]);
            }
            $db_update = [];
            foreach($update as $key => $value){
               // $db_update =
            }
         //   dump($update);
        }


    }
}

