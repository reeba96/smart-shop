<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\Product;
use Illuminate\Support\LazyCollection;
use ICBTECH\PredictionIO\Jobs\importItemsJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY')."&event=\$set&entityType=item&limit=".env('PREDICTIONIO_QUERY_LIMIT');

            $response = $client->get($url);
            $entities = json_decode($response->getBody()->getContents());

            return view('predictionio::admin.items', compact('entities'));
            
        } catch (\Exception $e) {
            \Log::info($e);
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
        importItemsJob::dispatch()->onQueue('importItems');

        session()->flash('success', trans('admin::app.predictionio.items_successfully_imported') );
        
        return redirect()->back();
    }

}
