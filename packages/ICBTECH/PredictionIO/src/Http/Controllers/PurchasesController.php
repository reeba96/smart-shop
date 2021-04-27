<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Webkul\Sales\Models\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Webkul\Sales\Models\OrderItem;
use Modules\Pro\Jobs\importPurchasesJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY')."&event=buy&entityType=user&limit=".env('PREDICTIONIO_QUERY_LIMIT');
            
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
        importPurchasesJob::dispatch()->onQueue('importPurchases');

        session()->flash('success', trans('admin::app.predictionio.purchases_successfully_imported') );
        
        return redirect()->back();  
    }

}
