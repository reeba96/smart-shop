<?php

namespace Icbtech\Import\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Mtownsend\XmlToArray\XmlToArray;
use Illuminate\Support\Facades\DB;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Category\Models\Category;

class ImportController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getXml()
    {
        $url = "http://api.ewe.rs/share/backend/?user=go2networx&secretcode=58b30";
        $xml = "ewe.xml";

        $ch =curl_init();

        echo 'curl init';

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, false);
        //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        //      curl_setopt($ch, CURLOPT_CAINFO, realpath("certs/ca.pem"));
        //      curl_setopt ($ch, CURLOPT_SSLCERT, realpath("certs/client.pem"));
        //      curl_setopt($ch, CURLOPT_SSLKEY, realpath("certs/key.pem"));
        // curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "5817"); // pin vezan za B2B certifikat
        //      curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "tippnet"); // pin vezan za B2B certifikat

        $return = curl_exec ($ch);
        $info = curl_getinfo($ch);
       /* echo '<pre>';
        print_r($info);
        echo '</pre>';

        var_dump($return);*/
        Storage::disk('local')->put('data\ewe.xml', $return);
        curl_close ($ch);
    }

    public function parseXml(){

        $xml_string = Storage::disk('local')->get('data\ewe.xml');
        //var_dump( $xml_string);
   //     $xml = simplexml_load_string($xml_string);
    //    dump($xml);
/*
        $json = json_encode($xml);
        
        $array = collect(json_decode($json,TRUE));
*/

        $array = XmlToArray::convert($xml_string);
      
        $products = collect($array['product']);

        $categories =$products->pluck('subcategory','category');

        $categories_array = $categories->toArray();
        $categories_array_keys = array_keys($categories_array);


    
        $has_categories = CategoryTranslation::whereIn('name',array_keys($categories_array))->pluck('name')->toArray();

        $new_categories = array_diff($categories_array_keys,$has_categories);
       
//dump($new_categories);
        
        $cat_positions = [];

        foreach($new_categories as $category_item){
            if ( !empty($category_item)){
                $cat_id = DB::table('categories')->insertGetId(
                    ['position' => '', 'status' => 1, 'display_mode' => 'products_and_description' ]
                );
    
                $tr_id = DB::table('category_translations')->insertGetId(
                    ['category_id' => $cat_id, 'name' => $category_item, 'slug' => str_slug($category_item,'-'), 'description' => '', 'locale' => 'en' ]
                );

                //if ( !isset( $cat))
            }
            
        }


        $subcategories_array = $products->pluck('category','subcategory')->toArray();
        $subcategories_array_keys = array_keys($subcategories_array);

        $has_subcategories = CategoryTranslation::whereIn('name',array_keys($subcategories_array))->pluck('name')->toArray();

        $new_subcategories = array_diff($subcategories_array_keys,$has_subcategories);

        $main_categories = Category::join('category_translations','category_translations.category_id','=','categories.id')->get();
//dump($main_categories);
        foreach($new_subcategories as $subcategory_item) {

            if ( !empty($subcategory_item)){
                //find parent_id
                $main_category_name = $subcategories_array[$subcategory_item];
               
               
                $get_category =  $main_categories->where('name',$main_category_name)->first();
                if ( $get_category  ){
                //    dump($subcategory_item);
                  //  echo $get_category['id'];

                    $cat_id = DB::table('categories')->insertGetId(
                        ['position' => '', 
                         'status' => 1, 
                         'display_mode' => 'products_and_description',
                         'parent_id' =>  $get_category['id']]
                    );
        
                    $tr_id = DB::table('category_translations')->insertGetId(
                        ['category_id' => $cat_id, 
                         'name' => $subcategory_item, 
                         'slug' => str_slug($subcategory_item,'-'), 
                         'description' => '', 'locale' => 'en' ]
                    );


                }
echo '<br>';
                /*$cat_id = DB::table('categories')->insertGetId(
                    ['position' => '', 'status' => 1, 'display_mode' => 'products_and_description' ]
                );
    
                $tr_id = DB::table('category_translations')->insertGetId(
                    ['category_id' => $cat_id, 'name' => $category_item, 'slug' => str_slug($category_item,'-'), 'description' => '', 'locale' => 'en' ]
                );*/
            }


        }

        //dump(->first());
    }


    public function products(){
        DB::table('products')->whereRaw('1=1')->delete();
        DB::table('products_grid')->whereRaw('1=1')->delete();
        DB::table('product_categories')->whereRaw('1=1')->delete();

        $xml_string = Storage::disk('local')->get('data\ewe.xml');

        $array = XmlToArray::convert($xml_string);
      
        $products = collect($array['product']);

        $rows = [];

        $categories = Category::all();
        foreach($products as $product) {

/*"<id><![CDATA[RAC11350]]></id>
<manufacturer><![CDATA[EWE PC AMD]]></manufacturer>
<name><![CDATA[X4 845/8GB/1TB/GF1050 2GB]]></name>
<category><![CDATA[EWE računari]]></category>
<subcategory><![CDATA[AMD konfiguracije]]></subcategory>
<price><![CDATA[37003.82]]></price>
<price_rebate><![CDATA[33673.48]]></price_rebate>		
<vat><![CDATA[20]]></vat>				
<ean><![CDATA[8606011820495]]></ean>
<description>
<![CDATA[Procesor / Čipset - Klasa procesora: AMD® Athlon™ II X4 845 Broj jezgara procesora: 4 Radni takt procesora: 3.5GHz Procesorsko ležište (socket): AMD® FM2+ Model: ASUS A68HM-K Čipset: AMD® A68M Chipset  Memorija (RAM) - Memorija (RAM): 8GB Tip memorije: DDR3 Radni takt memorije: 1.600MHz  Grafika - Grafika: nVidia® GeForce® Grafički procesor: GT 1050 Količina memorije: 2GB Tip memorije: GDDR5  Skladištenje podataka - Tip skladištenja: Hard disk Hard disk: 1TB Hard disk interfejs: SATA III Optički uređaj: DVD±RW DL  Kućište / Napajanje - Model kućišta: RPC Black Snaga napajanja: 560W  Softver - Operativni sistem: Bez operativnog sistema  Periferni uređaji - Tastatura: E-Tech Black USB Miš: E-Tech Black USB  Reklamacioni period - Reklamacioni period: 36 meseci]]>		
</description>"*/
            $product_id = DB::table('products')->insertGetId(
                ['sku' => $product['id'], 
                 'type' => 'simple', 
                 'parent_id' => NULL,
                 'attribute_family_id' =>  1  //TODO ha attributumok lesznek a kategoriaknak akkor kell egy Query ide
                 ]
            );

            $product_grid_item = ['product_id' => $product_id, 
                    'attribute_family_name' => 'Default',
                    'sku' => $product['id'],
                    'type' => 'simple',
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => 1
            ];

            $product_category = $categories->where('name',$product['subcategory'])->first();
//dd($product_category);
            $rows [] = $product_grid_item;

            $pc_item = ['product_id' => $product_id,
                        'category_id' => $product_category->id
            ];
            $pc[] = $pc_item;
         
            if (count($rows) % 1000 == 0) { // ezres csoportokban történik a beírás
                DB::table('products_grid')->insert($rows);

                DB::table('product_categories')->insert($pc);
                $pc = [];
                $rows = [];
            }
        }

        dump($rows);
    }

}
