<?php


namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Product\Repositories\ProductRepository;
use GuzzleHttp\Client;
use Carbon\Carbon;
use ICBTECH\PredictionIO\Models\Views;

class ProductsCategoriesProxyController extends Controller
{
    /**
     * CategoryRepository object
     *
     * @var \Webkul\Category\Repositories\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * ProductRepository object
     *
     * @var \Webkul\Product\Repositories\ProductRepository
     */
    protected $productRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Category\Repositories\CategoryRepository  $categoryRepository
     * @param  \Webkul\Product\Repositories\ProductRepository  $productRepository
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    )
    {
        $this->categoryRepository = $categoryRepository;

        $this->productRepository = $productRepository;

        parent::__construct();
    }

    /**
     * Show product or category view. If neither category nor product matches, abort with code 404.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Exception
     */
    public function index(Request $request)
    {
        $slugOrPath = trim($request->getPathInfo(), '/');

        if (preg_match('/^([a-z0-9-]+\/?)+$/', $slugOrPath)) {

            if ($category = $this->categoryRepository->findByPath($slugOrPath)) {
                // If category enabled
                if($category->status == 1){
                    return view($this->_config['category_view'], compact('category'));
                }
            }

            if ($product = $this->productRepository->findBySlug($slugOrPath)) {
                if($product["status"] == 1){
                    $customer = auth()->guard('customer')->user();

                    // Check if logged in some user
                    if($customer){

                        // Save view to DB
                        Views::create([
                            'customer_id' => $customer->id,
                            'product_id' => $product->id
                        ]);

                        // Send view data to PredictionIO
                        $client = new Client([
                            'headers' => [
                                'Content-Type' => 'application/json',
                            ],
                        ]);
                    
                        try {
                            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY');
                            $response = $client->post($url, [
                                \GuzzleHttp\RequestOptions::JSON => [
                                    "event" => "view",
                                    "entityType" => "user",
                                    "entityId" => $customer->id,
                                    "targetEntityType" => "item",
                                    "targetEntityId" => $product->id,
                                    "eventTime" => Carbon::now()
                                ] 
                            ]);
                        } catch (GuzzleException $exception) {
                            session()->flash('error', trans('shop::app.customer.signup-form.failed'));

                            return redirect()->back();
                        }
                        
                    }
        
                    return view($this->_config['product_view'], compact('product', 'customer'));
                }
            }

            abort(404);
        }

        $sliderRepository = app('Webkul\Core\Repositories\SliderRepository');
        
        $sliderData = $sliderRepository
            ->where('channel_id', core()->getCurrentChannel()->id)
            ->where('locale', core()->getCurrentLocale()->code)
            ->get()
            ->toArray();

        return view('shop::home.index', compact('sliderData'));
    }
}