<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Webkul\Attribute\Models\AttributeFamily;
use Webkul\Attribute\Models\AttributeGroup;
use Webkul\Attribute\Models\Attribute;
use Webkul\Attribute\Models\AttributeTranslation;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Category\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Core\Models\Locale;
// use Webkul\Product\Models\ProductCategory;
use Webkul\Product\Models\ProductFlat;
// use Webkul\Product\Models\ProductGrid;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class importProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importProducts {params?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products to dB';

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
        echo "Import Products \n";
        $now = Carbon::now();
   //     dump ( $this->argument('params'));
        $currency_rate = new Client();
        $res = $currency_rate->request('GET', 'https://kurs.resenje.org/api/v1/currencies/eur/rates/today');
        $response = json_decode($res->getBody());
        $middle_exchange_rate = $response->exchange_middle;
        $exchange_rate = $middle_exchange_rate * 1.04937;
        echo "Exchange_rate:" .$exchange_rate ."\n";

        $channel = 'default';
        
        $locale_code = 'sr';

        $locale = Locale::where('code',$locale_code)->first();

        if(!$locale){
            exit("Error: Locale '$locale_code' is missing \n\n");
        }
        $locale_id = $locale->id;

        if ($this->argument('params') == 'fresh' ) {
            DB::table('products')->whereRaw('1=1')->delete();
            DB::table('product_flat')->whereRaw('1=1')->delete();
            DB::table('product_categories')->whereRaw('1=1')->delete();
            DB::table('product_attribute_values')->whereRaw('1=1')->delete();
            DB::table('attributes')->whereRaw('id > 25')->delete();
            DB::table('attribute_groups')->whereRaw('id > 5')->delete();
        }
       /* INSERT INTO `attributes` (`id`, `code`, `admin_name`, `type`, `validation`, `position`, `is_required`, `is_unique`, `value_per_locale`, `value_per_channel`, `is_filterable`, `is_configurable`, `is_user_defined`, `is_visible_on_front`, `created_at`, `updated_at`, `swatch_type`, `use_in_flat`, `is_comparable`) VALUES
        (25, 'brand', 'Brand', 'select', NULL, 25, 0, 0, 0, 0, 1, 0, 0, 1, '2020-10-08 13:43:08', '2020-10-08 13:43:08', NULL, 1, 0);
        COMMIT;*/
        

        $categories = Category::all();
        $attribute_groups = AttributeGroup::all();
        $attribute_families = AttributeFamily::all();

        $attributes = Attribute::all();

        $all_xml_sku = [];

     
        // composer require prewk/xml-string-streamer // required

        $streamer = \Prewk\XmlStringStreamer::createStringWalkerParser( ltrim(Storage::disk('local')->url('app/data/ewe.xml'),'/' ) );
        $i = 0;
    
        while ($node = $streamer->getNode()) {
            
            if ($this->argument('params') == 'limit' && $i >5 ) {
               break;
            }
            $product = XmlToArray::convert($node);
            
          //  dump($product); 
        //    $simpleXmlNode = simplexml_load_string($node);
            if ( empty($product['ean'])) {
             //   dump($product); exit;
                $product['ean'] = $product['id'];
            }
            $product_sku = $product['ean'];
            $ewe_product_id = (string)$product['id'];
            $product_category = (string)$product['category'];
            $product_subcategory = (string)$product['subcategory'];
            $product_name = (string)$product['name'];
            $product_description = (string)$product['description'];
            $product_price = (string)$product['price'];
            $product_price_rebate = (string)$product['price_rebate'];
            $product_manufacturer = (string)$product['manufacturer'];
            $product_retail_price =  isset($product['recommended_retail_price']) ? $product['recommended_retail_price'] : 0;

     //   $bar = $this->output->createProgressBar(count($products));
     //   $bar->start();

       // foreach($products as $product) {

            $product_attribute_names = [];
            $sku = $product_sku;

            $all_xml_sku[] = $sku;
         
            if ( empty($product_category) ){
                dump('Empty product cateogry :continue');
                continue;
            }
                


          //  if( !in_array($product['category'], [ 'Procesori', 'Memorije']) ){
              //  echo $product['category']. ' ';
              //  continue;
         //   }



         

            if( !isset($product_category) ) {
                dump('!isset($product_category)');
                    //specijalna ponuda
                    continue;
            }
            else{
                $product_main_category = $categories->where('name',$product_category)->first();
            }
        //    $attr_family_id = $attribute_families->where('name',$product_main_category->name)->first()->id;
            $attr_family  = $attribute_families->where('name',$product_subcategory)->first();
            if ( !isset($attr_family)){
                dump(['subcategory attribute error:'=>$product_subcategory]);
                continue;
            }
            else{
                $attr_family_id = $attr_family->id;
            }
          
            $product_category = $categories->where('name',$product_subcategory)->first();
            if( !$product_category ){
                dump(['category not exist:'=>$product_subcategory]);
                continue;
            }
           
            $db_product = Product::updateOrCreate(
                [ 'sku' => $sku ],
                [
                    'type' => 'simple',
                    'parent_id' => NULL,
                   
                    'attribute_family_id' =>  $attr_family_id,
                    'ewe_product_id' => $ewe_product_id
                ]
            );
         
            $product_id = $db_product->id;

            dump($i++.' '.$ewe_product_id.' id:'. $product_id.' '.$product_name);
            
            $product_pav_array = [];

            if ( isset($product['specifications']) ){
//dd($product['specifications']);
              //  echo '.';
                foreach( $product['specifications']['attribute_group'] as $xml_data){
                    $spec_data = (array)$xml_data;
                  //  dump($spec_data);
                //  echo ',';

                    if( !isset($spec_data["@attributes"])){
                    //   dump(['spec' => $product['specifications'],'spec_data' => $spec_data ]);

                        $attribute_group_name = $product['specifications']['attribute_group']['@attributes']['name'];
                        $spec_attributes_array = $spec_data;
                    }
                    else{
                        $attribute_group_name = $spec_data["@attributes"]['name'];
                        if (!isset($spec_data["attribute"]) ){
                        //  dump(['spec' => $product['specifications'],'spec_data' => $spec_data ]);
                        //   dump($attribute_group_name);
                            $spec_attributes_array = $spec_data;
                        }
                        else{
                            $spec_attributes_array = $spec_data['attribute'];
                        }

                    }

                      

                    $db_attribute_group = $attribute_groups->where('name',$attribute_group_name)
                        ->where('attribute_family_id',$attr_family_id)
                        ->first();

                 //   dump(['attribute_group_name' => $attribute_group_name]);

                //    dump($db_attribute_group);
      //              dump(['db_attribute_group' => $db_attribute_group]);
    //                dump($attribute_group_name);
                    if (!$db_attribute_group){
                        
                        echo 'NEW attribute_group_name: '. $attribute_group_name ."\n";
                        $group = AttributeGroup::where('attribute_family_id',$attr_family_id)->get();
                        $attribute_group_data =  [
                            'name' => $attribute_group_name,
                            'position' => count($group)+1,
                            'is_user_defined' => 0,
                            'attribute_family_id' => $attr_family_id
                        ];
                        $attribute_group = AttributeGroup::create($attribute_group_data);
                        $attribute_groups->push($attribute_group);
                        $attribute_group_id = $attribute_group->id;
                    }
                    else{
                        $attribute_group_id = $db_attribute_group->id;
                    }
                //  dd($db_attribute_group);
                //     dump($spec_attributes_array);
                    foreach( $spec_attributes_array as $spec_attr){ //make attribute values
                     
                   //     dump('make attribute values');
                     
 //dd($spec_attributes_array);
                        if ( isset($spec_attr['@attributes']) ){
                      //      echo '.';
                            $value = $spec_attr['value'];
                            $attr_code = str_slug($spec_attr['@attributes']['name'],'_').'_'.$attr_family->code;
//dump($product_attribute_names);
//dump(['attr_code'=>$attr_code]);

                            if(isset($product_attribute_names[$attr_code])){
                                $attr_code = $attr_code.'__'. str_slug($attribute_group_name,'_');
                            }
                            $product_attribute_names[] = $attr_code;
                            if  ($attr_code == 'model'){
                               // dump($product_attribute_names);
                            }
                            $db_attribute = $attributes->where('code',$attr_code)->first();
                            if ( !$db_attribute){ //attribute not exist, create one
                                $insert_attribute = [
                                    'code'=> $attr_code,
                                    'admin_name' => $spec_attr['@attributes']['name'],
                                    'type' => 'text',
                                    'is_filterable' => 0,
                                    'is_configurable' => 0,
                                    'is_user_defined' => 1,
                                    'is_visible_on_front' => 1,
                                    'value_per_locale_1' => 1
                                ];
                                $db_attribute = Attribute::create($insert_attribute);
                                $attributes->push($db_attribute);
//dd($db_attribute);
                                $insert_attribute_translation = [
                                    'locale' => $locale_code,
                                    'name' =>  $spec_attr['@attributes']['name'],
                                    'attribute_id' => $db_attribute->id
                                ];
//dump($insert_attribute_translation);
                                $db_attribute_translation = AttributeTranslation::create($insert_attribute_translation);

                                //map it together
                                $count_attr_gr_map = DB::table('attribute_group_mappings')->where('attribute_group_id',$attribute_group_id)->count();
                                DB::table('attribute_group_mappings')->insert([
                                    'attribute_id' => $db_attribute->id,
                                    'attribute_group_id' => $attribute_group_id,
                                    'position' => $count_attr_gr_map+1
                                ]);

                                //set the value
                            //    dd($spec_attr['@attributes']);
                       //         $spec_attr['@attributes']['value']);
                                if ( is_array($value)){
                                    $combined_value = '';
                                    foreach($value as $value_item){
                                        $combined_value .= $value_item;
                                    }
                                    $value = $combined_value;
                                }


                                /*
                                $product_pav_array[$db_attribute->id] =  [
                                    'attribute_id' => $db_attribute->id ,
                                    'product_id' => $product_id ,
                                    'text_value' => $value,
                                    'boolean_value' => NULL,
                                    'integer_value' => NULL,
                                    'float_value'=> NULL
                                ];
                                */
                            // dump($product_pav_array);
                            }
                            else{
                                $count_attr_gr_map = DB::table('attribute_group_mappings')
                                    ->where('attribute_group_id',$attribute_group_id)
                                    ->where('attribute_id',$db_attribute->id)
                                    ->count();

                                if ($count_attr_gr_map == 0){
                                    DB::table('attribute_group_mappings')->insert([
                                        'attribute_id' => $db_attribute->id,
                                        'attribute_group_id' => $attribute_group_id,
                                        'position' => $count_attr_gr_map+1
                                    ]);
                                }

                                //set the value
                                if ( is_array($value)){
                                    $combined_value = '';
                                    foreach($value as $value_item){
                                        $combined_value .= $value_item;
                                    }
                                    $value = $combined_value;
                                }
                                if( !isset($product_pav_array[$db_attribute->id]) || $product_pav_array[$db_attribute->id]['product_id']!= $product_id){

                                    $product_pav_array[$db_attribute->id] =  [
                                        'attribute_id' => $db_attribute->id ,
                                        'product_id' => $product_id ,
                                        'text_value' => $value,
                                        'boolean_value' => NULL,
                                        'integer_value' => NULL,
                                        'float_value'=> NULL
                                    ];
                            
                                   // dump($product_pav_array);
                                }

                                if ( $db_attribute->id == 11){
                                 /*   dump( [ 'attribute_id' => $db_attribute->id ,
                                    'product_id' => $product_id ,
                                    'text_value' => $value,
                                    'boolean_value' => NULL,
                                    'integer_value' => NULL,
                                    'float_value'=> NULL ]);*/
                                }
                            }
                        }
                    }
                   //   dump($attribute_group_name);
              //        dump($attribute_group);
                }
            }



            $url_key = str_slug($product_name,'-');
            $price_euro =  $product_price;

            $price = $price_euro * $exchange_rate * 1.2;
            $cost = $product_price_rebate * $exchange_rate * 1.2;

            $pav_array = [
                ['attribute_id' => '1',/*'code' => 'sku'*/                  'product_id' => $product_id ,'text_value' => $sku,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '2',/*'code' => 'name'*/                 'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '3',/*'code' => 'url_key'*/              'product_id' => $product_id ,'text_value' =>$url_key,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '4',/*'code' => 'tax_category_id'*/      'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => 0, 'float_value'=> NULL],
                ['attribute_id' => '5',/*'code' => 'new'*/                  'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '6',/*'code' => 'featured'*/             'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '7',/*'code' => 'visible_individually'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '8',/*'code' => 'status'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '9',/*'code' => 'short_description'*/    'product_id' => $product_id ,'text_value' => $product_description,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '10',/*'code' => 'description'*/         'product_id' => $product_id ,'text_value' => $product_description,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '11',/*'code' => 'price'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $price],
                ['attribute_id' => '12',/*'code' => 'cost'*/                'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $cost],
                ['attribute_id' => '13',/*'code' => 'special_price'*/       'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '14',/*'code' => 'special_price_from'*/  'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '15',/*'code' => 'special_price_to'*/    'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '16',/*'code' => 'meta_title'*/          'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '17',/*'code' => 'meta_keywords'*/       'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '18',/*'code' => 'meta_description'*/    'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '19',/*'code' => 'width'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '20',/*'code' => 'height'*/              'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '21',/*'code' => 'depth'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '22',/*'code' => 'weight'*/              'product_id' => $product_id ,'text_value' => 1,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                ['attribute_id' => '25',/*'code' => 'manufacturer'*/        'product_id' => $product_id ,'text_value' => 1,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL]
            ];

            if ($db_product->wasRecentlyCreated) { //newly created product

                if ( $product_pav_array){
                    foreach ($product_pav_array as $pav_item){
                        $pav_array[] = $pav_item;
                    }
                }

                foreach( $pav_array as $key => $value){
                    /* for some reason featured, new, visible individually, status is not channel/locale specific */
                    if ( in_array($key,[1,8,9,15,16,17])){
                        $pav_array[$key]['locale'] = $locale_code;
                    }
                    else{
                        $pav_array[$key]['locale'] = NULL;
                    }

                    if ( in_array($key,[1,3,8,9,11,13,14,15,16,17])){
                        $pav_array[$key]['channel'] = $channel;
                    }
                    else{
                        $pav_array[$key]['channel'] = NULL;
                    }
                    
                }
              
                DB::table('product_attribute_values')->insert($pav_array);

            }
            else{ //check and update the product attributed values if necessary
                foreach ($pav_array as $pav_item){

                    $field = '';

                    $values = [
                        1 => $sku,
                        2 => $product_name,
                    //    3 => $url_key,
                        9 => $product_description,
                        10 => $product_description,
                        11 => $price,
                        12 => $cost,
                        16 => $product_name,
                        18 => $product_name,
                        25 => $product_manufacturer
                    ];


                    $item_attribute_id = $pav_item['attribute_id'];
                    if ( in_array($item_attribute_id,[1,2,9,10,16,18,25]) ){
                        $field = 'text_value';
                    }
                    else if ( in_array($item_attribute_id,[11,12]) ){
                        $field = 'float_value';
                    }

                    if ( $field ){
                        $where_arr = [
                            'attribute_id' => $item_attribute_id,
                            'product_id' => $product_id ,
                            $field => $values[$item_attribute_id]
                        ];

                        $db_pav = ProductAttributeValue::where($where_arr)->first();

                        if (!$db_pav){ //not found, the value has changed, need to UPDATE
                         //   dump(['attribute_id' => $pav_item['attribute_id'],'field' => $field,'value' => $values[$item_attribute_id]]);
                            /*ProductAttributeValue::where('attribute_id', $where_arr['attribute_id'])
                                ->where('product_id',$product_id)
                                ->update([$field => $values[$item_attribute_id]]);
*/
                            ProductAttributeValue::updateOrCreate(
                                ['attribute_id' => $where_arr['attribute_id'],'product_id' => $product_id],
                                [$field => $values[$item_attribute_id]]
                            );
                        }

                    }


                }

        /*       

               // $db_pav = DB::table('product_attribute_values')->where($where_arr)->get();
                    //                                dd($where_arr, $db_pav);

                $db_pav = ProductAttributeValue::where($where_arr)->first();

                if (!$db_pav){ //not found UPDATE
                    ProductAttributeValue::where('attribute_id', $where_arr['attribute_id'])
                        ->where('product_id',$where_arr['product_id'])
                        ->update(['float_value' => $product_price]);
                }

                 */

            }

            // ProductGrid::updateOrCreate(
            //     ['product_id' => $product_id],
            //     [
            //         'attribute_family_name' => $product_subcategory, //'Default',
            //         'sku' => $sku,
            //         'type' => 'simple',
            //         'name' => $product_name,
            //         'price' => $price,
            //         'quantity' => 1,
            //         'status' => 1
            //     ]
            // );

           /* $product_grid_item = [
                'product_id' => $product_id,
                'attribute_family_name' => $product['subcategory'], //'Default',
                'sku' => $sku,
                'type' => 'simple',
                'name' => $product['name'],
                'price' => $price,
                'quantity' => 1,
                'status' => 1
            ];

            $rows [] = $product_grid_item;

            */

            if(!Schema::hasColumn('product_flat', 'manufacturer')){

                Schema::table('product_flat', function (Blueprint $table) {
                    $table->string('manufacturer')->nullable();
                });

            };

            DB::table('product_categories')->updateOrInsert(
                [
                    'product_id' => $product_id,
                    'category_id' => $product_category->id
                ]
            );
    
           /*
            $pc_item = ['product_id' => $product_id,
                'category_id' => $product_category->id
            ];
            $pc[] = $pc_item;*/

            //add to the main category too


            if ($product_category->parent_id){
              /*  $pc_item = ['product_id' => $product_id,
                    'category_id' => $product_category->parent_id
                ];
                $pc[] = $pc_item;*/
                DB::table('product_categories')->updateOrInsert(
                    [
                        'product_id' => $product_id,
                        'category_id' => $product_category->parent_id
                    ]
                );

            }

            if(empty($price)){
                $db_product_flat = ProductFlat::updateOrCreate(
                    [ 'sku' => $sku ],
                    [
                        'name' => $product_name,
                        'description' => $product_description,
                        'url_key' =>$url_key,
                        'new' => 0,
                        'featured' => 0,
                        'status' => 1,
                        'thumbnail' => NULL,
                        'price' => $price_conversion,
                        'cost' => $cost,
                        'special_price' => NULL,
                        'special_price_from' => NULL,
                        'special_price_to' => NULL,
                        'weight' => 1,
                        'created_at' => $now,
                        'locale' => $locale_code,
                        'channel' => $channel,
                        'product_id' => $product_id,
                        'parent_id' => NULL,
                        'visible_individually' => 1,
                        'min_price' => NULL,
                        'max_price' => NULL,
                        'manufacturer' => $product_manufacturer
                    ]
                );

            }
            else {
                $db_product_flat = ProductFlat::updateOrCreate(
                    [ 'sku' => $sku ],
                    [
                        'name' => $product_name,
                        'description' => $product_description,
                        'url_key' =>$url_key,
                        'new' => 0,
                        'featured' => 0,
                        'status' => 1,
                        'thumbnail' => NULL,
                        'price' => $price,
                        'cost' => $cost,
                        'special_price' => NULL,
                        'special_price_from' => NULL,
                        'special_price_to' => NULL,
                        'weight' => 1,
                        'created_at' => $now,
                        'locale' => $locale_code,
                        'channel' => $channel,
                        'product_id' => $product_id,
                        'parent_id' => NULL,
                        'visible_individually' => 1,
                        'min_price' => NULL,
                        'max_price' => NULL,
                        'manufacturer' => $product_manufacturer
                    ]
                );

            }
        }

     
      
        // set active = 0 for missing products from XML
        $all_product_sku = Product::select('sku')->get();
    //    dump($all_product_sku->whereNotIn('sku',array_values($all_xml_sku) )->count());
        $inactive_product_skus = $all_product_sku->whereNotIn('sku',array_values($all_xml_sku))->pluck('sku');
        ProductFlat::whereIn('sku',$inactive_product_skus)->update(['status' =>  0]);
    }
}