<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Core\Repositories\SliderRepository;
use Webkul\Product\Repositories\SearchRepository;
use Webkul\Product\Models\Product;
use ICBTECH\PredictionIO\Models\RecommendedProducts;

class HomeController extends Controller
{
    /**
     * SliderRepository object
     *
     * @var \Webkul\Core\Repositories\SliderRepository
    */
    protected $sliderRepository;

    /**
     * SearchRepository object
     *
     * @var \Webkul\Core\Repositories\SearchRepository
    */
    protected $searchRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Core\Repositories\SliderRepository  $sliderRepository
     * @param  \Webkul\Product\Repositories\SearchRepository  $searchRepository
     * @return void
    */
    public function __construct(
        SliderRepository $sliderRepository,
        SearchRepository $searchRepository
    )
    {
        $this->sliderRepository = $sliderRepository;

        $this->searchRepository = $searchRepository;

        parent::__construct();
    }

    /**
     * loads the home page for the storefront
     * 
     * @return \Illuminate\View\View 
     */
    public function index()
    {
        $customer = auth()->guard('customer')->user();

        // Check if logged in some user
        if($customer){

            $products = DB::table('products')
                ->join('recommended_products', 'products.id', '=', 'recommended_products.product_id')
                ->join('product_images', 'products.id', '=', 'product_images.product_id')
                ->join('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->select('products.id as id','product_images.path as path', 'product_flat.*', 'recommended_products.*')
                ->where('recommended_products.customer_id', $customer->id )
                ->orderBy('score', 'desc')
                ->get();

            $previous_product_id = null;

            foreach($products as $key => $product){
                
                if($product->id == $previous_product_id) {
                    unset($products[$key]);
                }

                $previous_product_id = $product->id;
            }

            $products = $products->values()->all();
            
            // Check recommended products number
            $number_of_products = count($products);
            
            // Products with height scores
            $related_products = DB::table('products')
                ->join('recommended_products', 'products.id', '=', 'recommended_products.product_id')
                ->join('product_images', 'products.id', '=', 'product_images.product_id')
                ->join('product_flat', 'products.id', '=', 'product_flat.product_id')
                ->orderBy('score', 'desc')
                ->get();

            $related_previous_product_id = null;

            foreach($related_products as $key => $related_product){
                
                if($related_product->id == $related_previous_product_id) {
                    unset($related_products[$key]);
                }

                $related_previous_product_id = $related_product->id;
            }

            $related_products = $related_products->values()->all();
            
            if( $number_of_products == 1 ) {

                $product_1 = $products[0];
                $product_2 = $related_products[0];
                $product_3 = $related_products[1];
                
            } else if( $number_of_products == 2 ) {

                $product_1 = $products[0];
                $product_2 = $products[1];
                $product_3 = $products[0];

            } else if( $number_of_products >= 3 ){
                
                $product_1 = $products[0];
                $product_2 = $products[1];
                $product_3 = $products[2];
                
            } else {

                if( isset($related_products[0]) ) {
                    $product_1 = $related_products[0];
                    $product_2 = $related_products[1];
                    $product_3 = $related_products[2];
                }
                
            }
        }
        
        $currentChannel = core()->getCurrentChannel();

        $currentLocale = core()->getCurrentLocale();

        $sliderData = $this->sliderRepository
            ->where('channel_id', $currentChannel->id)
            ->where('locale', $currentLocale->code)
            ->get()
            ->toArray();

        if(isset($product_1) && isset($product_2) && isset($product_3)) {
            return view($this->_config['view'], compact('sliderData', 'product_1', 'product_2', 'product_3'));
        } else {
            return view($this->_config['view'], compact('sliderData'));
        }
        
    }

    /**
     * loads the home page for the storefront
     * 
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }

    /**
     * Upload image for product search with machine learning
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $url = $this->searchRepository->uploadSearchImage(request()->all());

        return $url; 
    }
}