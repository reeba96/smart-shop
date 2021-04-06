<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Webkul\Product\Models\Product;
use GuzzleHttp\Client;

class ItemsController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

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
        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get data from predictionio
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
       
        try {
            $url = env('PREDICTIONIO_URL').env('PREDICTIONIO_ACCESS_KEY')."&limit=".env('PREDICTIONIO_QUERY_LIMIT');

            $response = $client->get($url);
            $entities = json_decode($response->getBody()->getContents());

            return view('predictionio::admin.items', compact('entities'));
            
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.empty_pio') );

            return redirect()->back();
        }
    }

    /**
     * Importing existed products to predictionio.
     *
     * @return \Illuminate\View\View
     */
    public function importItems()
    {   
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $url = env('PREDICTIONIO_URL').env('PREDICTIONIO_ACCESS_KEY');
        $products = Product::get();

        try {
            foreach($products as $product){
                
                $categories = DB::table('product_categories')->where('product_id', $product->id)->pluck('category_id');

                $response = $client->post($url, [
                    \GuzzleHttp\RequestOptions::JSON => [
                        "event" => "\$set",
                        "entityType" => "item",
                        "entityId" => $product->id,
                        "properties" => [
                            "categories" => $categories
                        ],
                        "eventTime" => $product->created_at
                    ] 
                ]); 
                
            }

            session()->flash('success', trans('admin::app.predictionio.items_successfully_imported') );
            return redirect()->back();   
        
        } catch (\Exception $e) {
            \Log::info($e);
            session()->flash('error', trans('admin::app.predictionio.unexpected_error_occured') );
            return redirect()->back();
        }
    }

}
