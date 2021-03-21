<?php

namespace ICBTECH\PredictionIO\Http\Controllers\Api;

use Webkul\Attribute\Models\AttributeFamily;
use Webkul\Attribute\Models\AttributeGroup;
use Webkul\Attribute\Models\Attribute;
use Webkul\Attribute\Models\AttributeTranslation;
use Webkul\Category\Models\CategoryTranslation;
use Webkul\Category\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductAttributeValue;
use Webkul\Core\Models\Locale;
use Webkul\Product\Models\ProductFlat;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request)
    {
        //\Log::notice(['request' => $request]);
        $now = Carbon::now();
        $channel = 'default';

        $sku = $request->sku;

        $data = $request->input();
        
        \Log::notice(['request' => $data]);
      
        $price = $request->price;
        $cost = $price;
     
        $product_manufacturer = '';

        $attr_family  = AttributeFamily::first();
//dd($attr_family);
//\Log::notice(['attr_family' => $attr_family]);
        $product = Product::updateOrCreate(
            [ 'sku' => $sku ],
            [
                'type' => $request->type,
                'parent_id' => NULL,
                'attribute_family_id' =>  $attr_family->id,
            ]
        );
       //\Log::notice(['db_product' => $product]);
    
        $product_id = $product->id;

        foreach ( $data['attributes'] as $attribute ){
                /* 'product_id' => '1',
      'locale' => 'en',
      'name' => 'first device',
      'url_key' => 'dd',
      'description' => 'dd',*/
            $locale_code = $attribute['locale'];
            $product_name = $attribute['name'];
            $product_description = $attribute['description'];
            $url_key = $request->url_key;
                
            $pav_array = [
                1 =>['attribute_id' => 1,/*'code' => 'sku'*/                  'product_id' => $product_id ,'text_value' => $sku,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                2 =>['attribute_id' => 2,/*'code' => 'name'*/                 'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                3 =>['attribute_id' => 3,/*'code' => 'url_key'*/              'product_id' => $product_id ,'text_value' => $url_key,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                4 =>['attribute_id' => 4,/*'code' => 'tax_category_id'*/      'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => 0, 'float_value'=> NULL],
                5 =>['attribute_id' => 5,/*'code' => 'new'*/                  'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                6 =>['attribute_id' => 6,/*'code' => 'featured'*/             'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                7 =>['attribute_id' => 7,/*'code' => 'visible_individually'*/ 'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                8 =>['attribute_id' => 8,/*'code' => 'status'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => 1, 'integer_value' => NULL, 'float_value'=> NULL],
                9 =>['attribute_id' => 9,/*'code' => 'short_description'*/    'product_id' => $product_id ,'text_value' => $product_description,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                10 =>['attribute_id' => 10,/*'code' => 'description'*/         'product_id' => $product_id ,'text_value' => $product_description,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                11 =>['attribute_id' => 11,/*'code' => 'price'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $price],
                12 =>['attribute_id' => 12,/*'code' => 'cost'*/                'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL,'float_value'=> $cost],
                13 =>['attribute_id' => 13,/*'code' => 'special_price'*/       'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                14 =>['attribute_id' => 14,/*'code' => 'special_price_from'*/  'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                15 =>['attribute_id' => 15,/*'code' => 'special_price_to'*/    'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                16 =>['attribute_id' => 16,/*'code' => 'meta_title'*/          'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                17 =>['attribute_id' => 17,/*'code' => 'meta_keywords'*/       'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                18 =>['attribute_id' => 18,/*'code' => 'meta_description'*/    'product_id' => $product_id ,'text_value' => $product_name,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                19 =>['attribute_id' => 19,/*'code' => 'width'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                20 =>['attribute_id' => 20,/*'code' => 'height'*/              'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                21 =>['attribute_id' => 21,/*'code' => 'depth'*/               'product_id' => $product_id ,'text_value' => NULL,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                22 =>['attribute_id' => 22,/*'code' => 'weight'*/              'product_id' => $product_id ,'text_value' => 1,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL],
                25 =>['attribute_id' => 25,/*'code' => 'manufacturer'*/        'product_id' => $product_id ,'text_value' => 1,'boolean_value' => NULL, 'integer_value' => NULL, 'float_value'=> NULL]
            ];


            foreach( $pav_array as $key => $value){
                
               
                if ( in_array($key,[2,9,10,16,17,18])){
                    $pav_array[$key]['locale'] = $locale_code;
                }
                else{
                    $pav_array[$key]['locale'] = NULL;
                }

                /* for some reason featured, new, visible individually, status is not channel/locale specific */
                if ( in_array($key,[2,3,4,8,9,10,12,13,14,15,16,17,18])){
                    $pav_array[$key]['channel'] = $channel;
                }
                else{
                    $pav_array[$key]['channel'] = NULL;
                }
                
            }
            \Log::info($pav_array);
            foreach ($pav_array as $pav_item){

              \Log::info($pav_item);
                ProductAttributeValue::updateOrCreate(
                    [   'attribute_id' => $pav_item['attribute_id'],'product_id' => $product_id,'locale' => $pav_item['locale']],
                    [   'text_value'    => $pav_item['text_value'],
                        'boolean_value' => $pav_item['boolean_value'], 
                        'integer_value' => $pav_item['integer_value'], 
                        'float_value'   => $pav_item['float_value'],
                        'channel'       => $pav_item['channel']]
                );

            }

         
        }
       
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

        return ['status' => $request->all()];
    }


}
