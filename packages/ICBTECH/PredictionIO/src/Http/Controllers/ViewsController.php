<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ICBTECH\PredictionIO\Models\Views;

class ViewsController extends Controller
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

            return view('predictionio::admin.views', compact('entities'));

        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.empty_pio') );

            return redirect()->back();
        }
    }

    /**
     * Importing existed views to predictionio.
     *
     * @return \Illuminate\View\View
     */
    public function importViews()
    {   
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY');

        $views = Views::get();
            
        try {
            foreach($views as $view){
               
                $response = $client->post($url, [
                    \GuzzleHttp\RequestOptions::JSON => [
                        "event" => "view",
                        "entityType" => "user",
                        "entityId" => $view->customer_id,
                        "targetEntityType" => "item",
                        "targetEntityId" => $view->product_id,
                        "eventTime" => $view->created_at
                    ] 
                ]); 
                
            }
           
            session()->flash('success', trans('admin::app.predictionio.views_successfully_imported') );
            return redirect()->back();   
        
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.unexpected_error_occured') );
            return redirect()->back();
        }
    }

    /**
     * Delete all view from table
     *
     * @return \Illuminate\View\View
     */
    public function delete()
    {
        Views::truncate();

        session()->flash('success', trans('admin::app.predictionio.deleting_successfully_completed'));

        return back()->with('status', trans('admin::app.predictionio.deleting_successfully_completed'));
    }

}
