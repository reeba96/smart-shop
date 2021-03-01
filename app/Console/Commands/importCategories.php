<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Category\Models\Category;
use Carbon\Carbon;

class importCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:importCategories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import categories to dB';

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
    public function handle(){

        //termék attribútumok miatt törölni kell a termékeket is kategória feltöltésnél
        DB::table('products')->whereRaw('1=1')->delete();
        DB::table('products_grid')->whereRaw('1=1')->delete();
        DB::table('product_categories')->whereRaw('1=1')->delete();
        DB::table('product_attribute_values')->whereRaw('1=1')->delete();

//seed
        DB::table('categories')->delete();

      /*  $attributes = ['position' => '1','image' => NULL,'status' => '1'];
        $node = new Category($attributes);
        $node->save();   // Saved as root
        
      
      /*  $now = Carbon::now();
        DB::table('categories')->insert([
            ['id' => '1','position' => '1','image' => NULL,'status' => '1','_lft' => '1','_rgt' => '14','parent_id' => NULL, 'created_at' => $now, 'updated_at' => $now]
        ]);
*/

    /*    DB::table('category_translations')->insert([
            ['name' => 'Root','slug' => 'root','description' => 'Root','meta_title' => '','meta_description' => '','meta_keywords' => '','category_id' =>$node->id,'locale' => 'en']
        ]);
*/
        DB::table('attribute_families')->where('id','!=',1)->delete();
        DB::table('attribute_group_mappings')->where('attribute_group_id','>',5)->delete(); // a default cucc bent marad
   /*     DB::table('attribute_families')->insert([
            ['id' => '1','name' => 'default','code' => 'default','status' => '1','is_user_defined' => 0]
        ]);*/

        $locale = 'sr';

        $xml_string = Storage::disk('local')->get('data\ewe.xml');

        $array = XmlToArray::convert($xml_string);
      
        $products = collect($array['product']);

        $categories =$products->pluck('subcategory','category');
//dd($categories);
        $categories_array = $categories->toArray();
        $categories_array_keys = array_keys($categories_array);
    
        $has_categories = CategoryTranslation::whereIn('name',array_keys($categories_array))->pluck('name')->toArray();

        $new_categories = array_diff($categories_array_keys,$has_categories);
       
        
        $cat_positions = [];


        $subcategories_array = $products->pluck('category','subcategory')->toArray();
        $subcategories_array_keys = array_keys($subcategories_array);

        $bar = $this->output->createProgressBar(count($subcategories_array) + count($new_categories));
        $bar->start();
        foreach($new_categories as $category_item){
            if ( !empty($category_item)){

                $slug = str_slug($category_item,'-');

            /*    $cat_id = DB::table('categories')->insertGetId(
                    ['position' => '', 'status' => 1, 'display_mode' => 'products_and_description' ]
                );*/
                $node = new Category( ['position' => '', 'status' => 1, 'display_mode' => 'products_and_description' ]);
                $node->save(); // Saved as root

                $tr_id = DB::table('category_translations')->insertGetId([
                    'category_id' => $node->id, 
                    'name' => $category_item, 
                    'slug' => $slug, 
                    'description' => $category_item, 
                    'meta_title' => $category_item,
                    'meta_description' => $category_item,
                    'meta_keywords' => $category_item,
                    'locale' => $locale 
                ]);
               
                /*   $attr_fam_id = DB::table('attribute_families')->insertGetId(
                    ['code' => $slug, 'name' => $category_item, 'status' => 1, 'is_user_defined' => 1 ]
                );*/
                /*DB::table('attribute_groups')->insert([
                        ['id' => '1','name' => 'General','position' => '1','is_user_defined' => '0','attribute_family_id' => '1'],
                        ['id' => '2','name' => 'Description','position' => '2','is_user_defined' => '0','attribute_family_id' => '1'],
                        ['id' => '3','name' => 'Meta Description','position' => '3','is_user_defined' => '0','attribute_family_id' => '1'],
                        ['id' => '4','name' => 'Price','position' => '4','is_user_defined' => '0','attribute_family_id' => '1'],
                        ['id' => '5','name' => 'Shipping','position' => '5','is_user_defined' => '0','attribute_family_id' => '1']
                    ]);
           
            dump(['attr_fam_id'=> $attr_fam_id]);

            $attr_gr1_id = DB::table('attribute_groups')->insertGetId(
                ['name' => 'General','position' => '1','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
            );
            
            $attr_gr2_id = DB::table('attribute_groups')->insertGetId(
                ['name' => 'Description','position' => '2','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
            );
            $attr_gr3_id = DB::table('attribute_groups')->insertGetId(
                ['name' => 'Meta Description','position' => '3','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
            );
            $attr_gr4_id = DB::table('attribute_groups')->insertGetId(
                ['name' => 'Price','position' => '4','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
            );
            $attr_gr5_id = DB::table('attribute_groups')->insertGetId(
                ['name' => 'Shipping','position' => '5','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
            );
    dump($attr_gr1_id,$attr_gr2_id,$attr_gr3_id,$attr_gr4_id,$attr_gr5_id);
            DB::table('attribute_group_mappings')->insert([
                ['attribute_id' => '1','attribute_group_id' => $attr_gr1_id,'position' => '1'],
                ['attribute_id' => '2','attribute_group_id' => $attr_gr1_id,'position' => '2'],
                ['attribute_id' => '3','attribute_group_id' => $attr_gr1_id,'position' => '3'],
                ['attribute_id' => '4','attribute_group_id' => $attr_gr1_id,'position' => '4'],
                ['attribute_id' => '5','attribute_group_id' => $attr_gr1_id,'position' => '5'],
                ['attribute_id' => '6','attribute_group_id' => $attr_gr1_id,'position' => '6'],
                ['attribute_id' => '7','attribute_group_id' => $attr_gr1_id,'position' => '7'],
                ['attribute_id' => '8','attribute_group_id' => $attr_gr1_id,'position' => '8'],
                ['attribute_id' => '9','attribute_group_id' => $attr_gr2_id,'position' => '1'],
                ['attribute_id' => '10','attribute_group_id' => $attr_gr2_id,'position' => '2'],
                ['attribute_id' => '11','attribute_group_id' => $attr_gr4_id,'position' => '1'],
                ['attribute_id' => '12','attribute_group_id' => $attr_gr4_id,'position' => '2'],
                ['attribute_id' => '13','attribute_group_id' => $attr_gr4_id,'position' => '3'],
                ['attribute_id' => '14','attribute_group_id' => $attr_gr4_id,'position' => '4'],
                ['attribute_id' => '15','attribute_group_id' => $attr_gr4_id,'position' => '5'],
                ['attribute_id' => '16','attribute_group_id' => $attr_gr3_id,'position' => '1'],
                ['attribute_id' => '17','attribute_group_id' => $attr_gr3_id,'position' => '2'],
                ['attribute_id' => '18','attribute_group_id' => $attr_gr3_id,'position' => '3'],
                ['attribute_id' => '19','attribute_group_id' => $attr_gr5_id,'position' => '1'],
                ['attribute_id' => '20','attribute_group_id' => $attr_gr5_id,'position' => '2'],
                ['attribute_id' => '21','attribute_group_id' => $attr_gr5_id,'position' => '3'],
                ['attribute_id' => '22','attribute_group_id' => $attr_gr5_id,'position' => '4'],
          //      ['attribute_id' => '23','attribute_group_id' => $attr_gr1_id,'position' => '9'],
          //      ['attribute_id' => '24','attribute_group_id' => $attr_gr1_id,'position' => '10']
            ]);
*/  
                $bar->advance();
            }
        }
      //  $categories =$products->pluck('subcategory','category');

        //$categories_array = $categories->toArray();

       
     

        foreach($subcategories_array as $subcategory_item => $maincategory_item) {
           // if( $subcategory_item == 'Dodatna oprema') {
              //  dump(['subcategory_item' => $subcategory_item,'maincategory_item' => $maincategory_item]);
          //  }

            $db_maincategory = Category::select('categories.*', 'categories.id as cat_id','category_translations.*', 'category_translations.id as category_translations_id')
                ->join('category_translations', function ($join) {
                    $join->on('category_translations.category_id','=','categories.id');
                })
                ->where('category_translations.name',$maincategory_item)
                ->whereNull('categories.parent_id')->first();
                if( $subcategory_item == 'Dodatna oprema') {
                  //  dump(['db_maincategory' => $db_maincategory]);
                }
            if ( $db_maincategory){
                $db_subcategory = Category::join('category_translations', function ($join) {
                    $join->on('category_translations.category_id','=','categories.id');
                })
                ->where('categories.parent_id',$db_maincategory->id)
                ->where('category_translations.name',$subcategory_item)
                ->whereNotNull('categories.parent_id')->first();

                //verfy slug
                $db_verify_maincategory = Category::select('categories.*', 'categories.id as cat_id','category_translations.*', 'category_translations.id as category_translations_id')
                    ->join('category_translations', function ($join) {
                        $join->on('category_translations.category_id','=','categories.id');
                    })
                    ->where('category_translations.name',$subcategory_item)
                    ->whereNull('categories.parent_id')->first();
                   
                if ($db_verify_maincategory){ // has tha same main category name
                    $sub_slug = str_slug($maincategory_item.' '.$subcategory_item,'-');
                  //  dump($db_verify_maincategory,$sub_slug);
                }
                else{
                    $sub_slug = str_slug($subcategory_item,'-');
                }

               /* if( $subcategory_item == 'Dodatna oprema') {
                    dump(['db_subcategory' => $db_subcategory]);
                }*/

                if( $db_subcategory ){
                    //dump($db_subcategory);
                }
                else{
                   /* $cat_id = DB::table('categories')->insertGetId(
                        ['position' => '', 
                         'status' => 1, 
                         'display_mode' => 'products_and_description',
                         //'_lft' => 2,
                         'parent_id' =>  $db_maincategory['cat_id'],]
                    );
        */
                    $main_category_node = Category::whereId($db_maincategory['cat_id'])->first();
                    $sub_category_node =  $main_category_node->children()->create([
                        'position' => '', 
                            'status' => 1, 
                            'display_mode' => 'products_and_description'
                    ]);

                    $tr_id = DB::table('category_translations')->insertGetId([
                        'category_id' => $sub_category_node->id, 
                        'name' => $subcategory_item, 
                        'slug' => $sub_slug, 
                        'description' => $category_item, 
                        'meta_title' => $category_item,
                        'meta_description' => $category_item,
                        'meta_keywords' => $category_item,
                        'locale' => $locale 
                    ]);
                    
                    $attr_fam_id = DB::table('attribute_families')->insertGetId(
                        ['code' => $sub_slug, 'name' => $subcategory_item, 'status' => 1, 'is_user_defined' => 1 ]
                    );
                   
               /*     if( $subcategory_item == 'Dodatna oprema') {
                        dump(['cat_id' => $cat_id,
                            'tr_id' => $tr_id,
                            'attr_fam_id' => $attr_fam_id]);
                    }*/
            //    dump(['attr_fam_id'=> $attr_fam_id]);
    
                    $attr_gr1_id = DB::table('attribute_groups')->insertGetId(
                        ['name' => 'General','position' => '1','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                    );
                    
                    $attr_gr2_id = DB::table('attribute_groups')->insertGetId(
                        ['name' => 'Description','position' => '2','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                    );
                    $attr_gr3_id = DB::table('attribute_groups')->insertGetId(
                        ['name' => 'Meta Description','position' => '3','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                    );
                    $attr_gr4_id = DB::table('attribute_groups')->insertGetId(
                        ['name' => 'Price','position' => '4','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                    );
                    $attr_gr5_id = DB::table('attribute_groups')->insertGetId(
                        ['name' => 'Shipping','position' => '5','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                    );
                //    dump($attr_gr1_id,$attr_gr2_id,$attr_gr3_id,$attr_gr4_id,$attr_gr5_id);
    
                    DB::table('attribute_group_mappings')->insert([
                        ['attribute_id' => '1','attribute_group_id' => $attr_gr1_id,'position' => '1'],
                        ['attribute_id' => '2','attribute_group_id' => $attr_gr1_id,'position' => '2'],
                        ['attribute_id' => '3','attribute_group_id' => $attr_gr1_id,'position' => '3'],
                        ['attribute_id' => '4','attribute_group_id' => $attr_gr1_id,'position' => '4'],
                        ['attribute_id' => '5','attribute_group_id' => $attr_gr1_id,'position' => '5'],
                        ['attribute_id' => '6','attribute_group_id' => $attr_gr1_id,'position' => '6'],
                        ['attribute_id' => '7','attribute_group_id' => $attr_gr1_id,'position' => '7'],
                        ['attribute_id' => '8','attribute_group_id' => $attr_gr1_id,'position' => '8'],
                        ['attribute_id' => '9','attribute_group_id' => $attr_gr2_id,'position' => '1'],
                        ['attribute_id' => '10','attribute_group_id' => $attr_gr2_id,'position' => '2'],
                        ['attribute_id' => '11','attribute_group_id' => $attr_gr4_id,'position' => '1'],
                        ['attribute_id' => '12','attribute_group_id' => $attr_gr4_id,'position' => '2'],
                        ['attribute_id' => '13','attribute_group_id' => $attr_gr4_id,'position' => '3'],
                        ['attribute_id' => '14','attribute_group_id' => $attr_gr4_id,'position' => '4'],
                        ['attribute_id' => '15','attribute_group_id' => $attr_gr4_id,'position' => '5'],
                        ['attribute_id' => '16','attribute_group_id' => $attr_gr3_id,'position' => '1'],
                        ['attribute_id' => '17','attribute_group_id' => $attr_gr3_id,'position' => '2'],
                        ['attribute_id' => '18','attribute_group_id' => $attr_gr3_id,'position' => '3'],
                        ['attribute_id' => '19','attribute_group_id' => $attr_gr5_id,'position' => '1'],
                        ['attribute_id' => '20','attribute_group_id' => $attr_gr5_id,'position' => '2'],
                        ['attribute_id' => '21','attribute_group_id' => $attr_gr5_id,'position' => '3'],
                        ['attribute_id' => '22','attribute_group_id' => $attr_gr5_id,'position' => '4'],
                //      ['attribute_id' => '23','attribute_group_id' => $attr_gr1_id,'position' => '9'],
                //      ['attribute_id' => '24','attribute_group_id' => $attr_gr1_id,'position' => '10']
                    ]);
                }
                
            }

            $bar->advance();
        }

        $bar->finish();
//dd($subcategories_array);
/*
        $has_subcategories = CategoryTranslation::whereIn('name',array_keys($subcategories_array))->pluck('name')->toArray();

        $new_subcategories = array_diff($subcategories_array_keys,$has_subcategories);

            $main_categories = Category::select('categories.*', 'categories.id as cat_id','category_translations.*', 'category_translations.id as category_translations_id')
            ->join('category_translations','category_translations.category_id','=','categories.id')->get();

        foreach($new_subcategories as $subcategory_item) {

            if ( !empty($subcategory_item)){
                //find parent_id
                $slug = str_slug($subcategory_item,'-');

                $main_category_name = $subcategories_array[$subcategory_item];
               
               
                $get_category =  $main_categories->where('name',$main_category_name)->first(); 
                if ( $get_category  ){

                    $cat_id = DB::table('categories')->insertGetId(
                        ['position' => '', 
                         'status' => 1, 
                         'display_mode' => 'products_and_description',
                         //'_lft' => 2,
                         'parent_id' =>  $get_category['cat_id'],]
                    );
        
                    $tr_id = DB::table('category_translations')->insertGetId(
                        ['category_id' => $cat_id, 
                         'name' => $subcategory_item, 
                         'slug' => str_slug($subcategory_item,'-'), 
                         'description' => '', 'locale' => 'en' ]
                    );

                 //   dd($$cat_id);
                }

                $attr_fam_id = DB::table('attribute_families')->insertGetId(
                    ['code' => $slug, 'name' => $subcategory_item, 'status' => 1, 'is_user_defined' => 1 ]
                );
               
            dump(['attr_fam_id'=> $attr_fam_id]);

                $attr_gr1_id = DB::table('attribute_groups')->insertGetId(
                    ['name' => 'General','position' => '1','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                );
                
                $attr_gr2_id = DB::table('attribute_groups')->insertGetId(
                    ['name' => 'Description','position' => '2','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                );
                $attr_gr3_id = DB::table('attribute_groups')->insertGetId(
                    ['name' => 'Meta Description','position' => '3','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                );
                $attr_gr4_id = DB::table('attribute_groups')->insertGetId(
                    ['name' => 'Price','position' => '4','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                );
                $attr_gr5_id = DB::table('attribute_groups')->insertGetId(
                    ['name' => 'Shipping','position' => '5','is_user_defined' => '0','attribute_family_id' => $attr_fam_id ]
                );
                dump($attr_gr1_id,$attr_gr2_id,$attr_gr3_id,$attr_gr4_id,$attr_gr5_id);

                DB::table('attribute_group_mappings')->insert([
                    ['attribute_id' => '1','attribute_group_id' => $attr_gr1_id,'position' => '1'],
                    ['attribute_id' => '2','attribute_group_id' => $attr_gr1_id,'position' => '2'],
                    ['attribute_id' => '3','attribute_group_id' => $attr_gr1_id,'position' => '3'],
                    ['attribute_id' => '4','attribute_group_id' => $attr_gr1_id,'position' => '4'],
                    ['attribute_id' => '5','attribute_group_id' => $attr_gr1_id,'position' => '5'],
                    ['attribute_id' => '6','attribute_group_id' => $attr_gr1_id,'position' => '6'],
                    ['attribute_id' => '7','attribute_group_id' => $attr_gr1_id,'position' => '7'],
                    ['attribute_id' => '8','attribute_group_id' => $attr_gr1_id,'position' => '8'],
                    ['attribute_id' => '9','attribute_group_id' => $attr_gr2_id,'position' => '1'],
                    ['attribute_id' => '10','attribute_group_id' => $attr_gr2_id,'position' => '2'],
                    ['attribute_id' => '11','attribute_group_id' => $attr_gr4_id,'position' => '1'],
                    ['attribute_id' => '12','attribute_group_id' => $attr_gr4_id,'position' => '2'],
                    ['attribute_id' => '13','attribute_group_id' => $attr_gr4_id,'position' => '3'],
                    ['attribute_id' => '14','attribute_group_id' => $attr_gr4_id,'position' => '4'],
                    ['attribute_id' => '15','attribute_group_id' => $attr_gr4_id,'position' => '5'],
                    ['attribute_id' => '16','attribute_group_id' => $attr_gr3_id,'position' => '1'],
                    ['attribute_id' => '17','attribute_group_id' => $attr_gr3_id,'position' => '2'],
                    ['attribute_id' => '18','attribute_group_id' => $attr_gr3_id,'position' => '3'],
                    ['attribute_id' => '19','attribute_group_id' => $attr_gr5_id,'position' => '1'],
                    ['attribute_id' => '20','attribute_group_id' => $attr_gr5_id,'position' => '2'],
                    ['attribute_id' => '21','attribute_group_id' => $attr_gr5_id,'position' => '3'],
                    ['attribute_id' => '22','attribute_group_id' => $attr_gr5_id,'position' => '4'],
            //      ['attribute_id' => '23','attribute_group_id' => $attr_gr1_id,'position' => '9'],
            //      ['attribute_id' => '24','attribute_group_id' => $attr_gr1_id,'position' => '10']
                ]);

              //  $cat_id = DB::table('categories')->insertGetId(
              //      ['position' => '', 'status' => 1, 'display_mode' => 'products_and_description' ]
             //   );
    
              //  $tr_id = DB::table('category_translations')->insertGetId(
              //      ['category_id' => $cat_id, 'name' => $category_item, 'slug' => str_slug($category_item,'-'), 'description' => '', 'locale' => 'en' ]
              //  );
            }


        }
*/
    }
}