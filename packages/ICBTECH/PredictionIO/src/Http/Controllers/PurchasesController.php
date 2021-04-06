<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Webkul\Sales\Models\OrderItem;
use Webkul\Sales\Models\Order;
use GuzzleHttp\Client;
use Carbon\Carbon;

class PurchasesController extends Controller
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
            
            return view('predictionio::admin.purchases', compact('entities'));

        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.empty_pio') );

            return redirect()->back();
        }
    }

    /**
     * Importing existed purchases to predictionio.
     *
     * @return \Illuminate\View\View
     */
    public function importPurchases()
    {   
        $orders = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('orders.customer_id as customer_id', 'order_items.product_id as product_id', 'order_items.created_at as created_at')
            ->get();

        try {

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $url = env('PREDICTIONIO_URL').env('PREDICTIONIO_ACCESS_KEY');
                
            foreach($orders as $order){
                
                $response = $client->post($url, [
                    \GuzzleHttp\RequestOptions::JSON => [
                        "event" => "buy",
                        "entityType" => "user",
                        "entityId" => $order->customer_id,
                        "targetEntityType" => "item",
                        "targetEntityId" => $order->product_id
                    ] 
                ]); 
                   
            }
            
            session()->flash('success', trans('admin::app.predictionio.users_successfully_imported') );
            return redirect()->back();   
        
        } catch (\GuzzleException $e) {
            \Log::info($e);
            session()->flash('error', trans('admin::app.predictionio.unexpected_error_occured') );
            return redirect()->back();
        }
    }

}
