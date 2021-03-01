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
use Webkul\Product\Models\ProductFlat;
use Carbon\Carbon;

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

   //     dump ( $this->argument('params'));
        $channel = 'quickshop';
        $locale = 'sr';
        
        if ($this->argument('params') == 'clean' ) {
            DB::table('products')->whereRaw('1=1')->delete();
            DB::table('products_grid')->whereRaw('1=1')->delete();
            DB::table('product_flat')->whereRaw('1=1')->delete();
            DB::table('product_categories')->whereRaw('1=1')->delete();
            DB::table('product_attribute_values')->whereRaw('1=1')->delete();
        }
        
        $xml_string = Storage::disk('local')->get('data\ewe.xml');
     //   DB::table('attributes')->whereRaw('id > 24')->delete();
        $array = XmlToArray::convert($xml_string);
      
        $products = collect($array['product']);

        $rows = [];
        $product_inventories = [];
        $product_flat = [];

        $bar = $this->output->createProgressBar(count($products));
        $bar->start();

        $categories = Category::all();
        $attribute_groups = AttributeGroup::all();
        $attribute_families = AttributeFamily::all();

        $attributes = Attribute::all();


        foreach($products as $product) {

            $product_attribute_names = [];
       //     if ( $product['id'] != 'CPU00909' && $product['id'] != 'CPU00832')
           //    continue;
            if ( !isset($product['category']) )
                continue; 
         
         
            if( !in_array($product['category'], [ 'Procesori', 'Memorije']) ){
              //  echo $product['category']. ' ';
              //  continue;
            }
                
         
            $sku = strtolower($product['id']);
            $now = Carbon::now();

            if( !isset($product['category']) ) {
                    //specijalna ponuda
                    continue;
            }
            else{
                $product_main_category = $categories->where('name',$product['category'])->first();
            }
            
        //    $attr_family_id = $attribute_families->where('name',$product_main_category->name)->first()->id;
      //  dd($product['category']);
            
            $attr_family  = $attribute_families->where('name',$product['subcategory'])->first();
            if ( !isset($attr_family)){
                dump(['subcategory attribute error:'=>$product]);
                continue;
            }
            else{
                $attr_family_id = $attr_family->id;
            }

            $product_category = $categories->where('name',$product['subcategory'])->first();
            if( !$product_category ){
                dump(['category not exist:'=>$product['subcategory']]);
                continue;
            }

            $db_product = Product::updateOrCreate(
                [ 'sku' => $sku ],
                [
                    'type' => 'simple', 
                    'parent_id' => NULL,
                    'created_at' => $now,
                    'attribute_family_id' =>  $attr_family_id
                ]
            );
            
            $product_id = $db_product->id;
           /* $product_id = DB::table('products')->insertGetId(
                [
                    'sku' => $sku, 
                    'type' => 'simple', 
                    'parent_id' => NULL,
                    'created_at' => $now,
                    'attribute_family_id' =>  $attr_family_id
                ]
            );*/

            

            dump($product['name']);
            $product_pav_array = [];
            if ( isset( $product['specifications']) ){
                foreach( $product['specifications']['attribute_group'] as $spec_data){
                      //dump($spec_data);
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
                      
                   //   dump(['attribute_group_name',$attribute_group_name]);
      
                    $db_attribute_group = $attribute_groups->where('name',$attribute_group_name)
                        ->where('attribute_family_id',$attr_family_id)
                        ->first();
              //      dump(['db_attribute_group' => $db_attribute_group->toArray()]);
                    if (!$db_attribute_group){
 // echo 'NEW ';
                        $group = AttributeGroup::where('attribute_family_id',$attr_family_id)->get();
                        $attribute_group = AttributeGroup::create([
                            'name' => $attribute_group_name,
                            'position' => count($group)+1,
                            'is_user_defined' => 0,
                            'attribute_family_id' => $attr_family_id
                        ]);
                        $attribute_groups->push($attribute_group);
                        $attribute_group_id = $attribute_group->id;
                    }
                    else{
                        $attribute_group_id = $db_attribute_group->id;
                    }
                //  dd($db_attribute_group);
                //     dump($spec_attributes_array);
                    foreach( $spec_attributes_array as $spec_attr){ //make attribute values
 //dd($spec_attributes_array);
                        if ( isset($spec_attr['@attributes']) ){ 
                            $value = $spec_attr['value'];
                            $attr_code = str_slug($spec_attr['@attributes']['name'],'_').'_'.$attr_family->code;
//dump($product_attribute_names);
                            

//dump(['attr_code'=>$attr_code]);
                            
                           // dump(['attr_code' => $attr_code ]);

                            if(isset($product_attribute_names[$attr_code])){
                                $attr_code = $attr_code.'__'. str_slug($attribute_group_name,'_');
                            }
                            $product_attribute_names[] = $attr_code;
                            if  ($attr_code == 'model'){
                                dump($product_attribute_names);
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
                                ];
                                $db_attribute = Attribute::create($insert_attribute);
                                $attributes->push($db_attribute);
//dd($db_attribute);
                                $insert_attribute_translation = [
                                    'locale' => $locale,
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
                                
                                $product_pav_array[$db_attribute->id] =  [
                                    'attribute_id' => $db_attribute->id ,
                                    'product_id' => $product_id ,
                                    'text_value' => $value,
                                    'boolean_value' => NULL, 
                                    'integer_value' => NULL, 
                                    'float_value'=> NULL
                                ];
                          //  dump($product_pav_array);
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
                                    if ( $db_attribute->id == 3649){
                                        echo 'SET';
                                        dump(['PAV' => $product_pav_array]);
                                    }
                                    $product_pav_array[$db_attribute->id] =  [
                                        'attribute_id' => $db_attribute->id ,
                                        'product_id' => $product_id ,
                                        'text_value' => $value,
                                        'boolean_value' => NULL, 
                                        'integer_value' => NULL, 
                                        'float_value'=> NULL
                                    ];
                                }
                                
                                if ( $db_attribute->id == 3649){
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
            
            //dd(1);

           
            $url_key = str_slug($product['name'],'-');
            $price =  $product['price'];
            $cost = $product['price_rebate'];
            
            if ($db_product->wasRecentlyCreated) { //newly created product
                $pav_array = [
                    ['attribute_id' => '1',/*'code' => 'sku'*/'product_id' => $product_id ,'text_value' => $sku,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '2',/*'code' => 'name'*/'product_id' => $product_id ,'text_value' => $product['name'],'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '3',/*'code' => 'url_key'*/'product_id' => $product_id ,'text_value' =>$url_key,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '4',/*'code' => 'tax_category_id'*/'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => 0, 'float_value'=> NULL],
                    ['attribute_id' => '5',/*'code' => 'new'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '6',/*'code' => 'featured'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '7',/*'code' => 'visible_individually'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '8',/*'code' => 'status'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '9',/*'code' => 'short_description'*/ 'product_id' => $product_id ,'text_value' => $product['description'],'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '10',/*'code' => 'description'*/ 'product_id' => $product_id ,'text_value' => $product['description'],'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '11',/*'code' => 'price'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $price],
                    ['attribute_id' => '12',/*'code' => 'cost'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $cost],
                    ['attribute_id' => '13',/*'code' => 'special_price'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '14',/*'code' => 'special_price_from'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '15',/*'code' => 'special_price_to'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '16',/*'code' => 'meta_title'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '17',/*'code' => 'meta_keywords'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '18',/*'code' => 'meta_description'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '19',/*'code' => 'width'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '20',/*'code' => 'height'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '21',/*'code' => 'depth'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                    ['attribute_id' => '22',/*'code' => 'weight'*/ 'product_id' => $product_id ,'text_value' => 1,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                //    ['attribute_id' => '23',/*'code' => 'color'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                //    ['attribute_id' => '24',/*'code' => 'size'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => 1, 'float_value'=> NULL],
                ];

                if ( $product_pav_array){
                    foreach ($product_pav_array as $pav_item){
                        $pav_array[] = $pav_item;
                    }
                }
                
                foreach( $pav_array as $key => $value){
                    $pav_array[$key]['locale'] = $locale;
                    $pav_array[$key]['channel'] = $channel;
                }
                DB::table('product_attribute_values')->insert($pav_array);

                $product_inventory_item = [
                    'qty' => 1 ,
                    'product_id' => $product_id,
                    'inventory_source_id' => 1,
                    'vendor_id' => 0 
                ];
                $product_inventories[] = $product_inventory_item;
            }
            
            

            $product_grid_item = ['product_id' => $product_id, 
                'attribute_family_name' => $product['subcategory'], //'Default',
                'sku' => $sku,
                'type' => 'simple',
                'name' => $product['name'],
                'price' => $price,
                'quantity' => 1,
                'status' => 1
            ];
       
            $rows [] = $product_grid_item;

            $pc_item = ['product_id' => $product_id,
                'category_id' => $product_category->id
            ];
            $pc[] = $pc_item;
            
            //add to the main category too
            if ($product_category->parent_id){
                $pc_item = ['product_id' => $product_id,
                    'category_id' => $product_category->parent_id
                ];
                $pc[] = $pc_item;
            }

            $db_product_flat = ProductFlat::updateOrCreate(
                [ 'sku' => $sku ],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
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
                    'locale' => $locale,
                    'channel' => $channel,
                    'product_id' => $product_id, 
                    'parent_id' => NULL,
                    'visible_individually' => 1, 
                    'min_price' => NULL,
                    'max_price' => NULL
                ]
            );

            /*$product_flat_item = [
                'sku' => $sku,
                'name' => $product['name'],
                'description' => $product['description'],
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
                'locale' => $locale,
                'channel' => $channel,
                'product_id' => $product_id, 
                'parent_id' => NULL,
                'visible_individually' => 1, 
                'min_price' => NULL,
                'max_price' => NULL
            ];*/
           // $product_flat[] = $product_flat_item;

            if (count($rows) % 10 == 0  ) { //  csoportokban történik a beírás
                DB::table('products_grid')->insert($rows);
                DB::table('product_categories')->insert($pc);
                DB::table('product_inventories')->insert($product_inventories);
           //     DB::table('product_flat')->insert($product_flat);
                $pc = [];
                $rows = [];
                $product_inventories = [];
                $product_flat = [];
            }
            
            $bar->advance();
        }
       
        if (count($rows) > 0 ) { //  write the rest...
            DB::table('products_grid')->insert($rows);
            DB::table('product_categories')->insert($pc);
            DB::table('product_inventories')->insert($product_inventories);
            DB::table('product_flat')->insert($product_flat);
            $pc = [];
            $rows = [];
            $product_inventories = [];
            $product_flat = [];
        }
        $bar->finish();
    }

    
}
