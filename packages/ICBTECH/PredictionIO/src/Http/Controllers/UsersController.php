<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Webkul\Customer\Models\Customer;
use GuzzleHttp\Client;

class UsersController extends Controller
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
            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY')."&event=\$set&entityType=user&limit=".env('PREDICTIONIO_QUERY_LIMIT');
            $response = $client->get($url);
            $entities = json_decode($response->getBody()->getContents());

            return view('predictionio::admin.users', compact('entities'));

        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.empty_pio') );

            return redirect()->back();
        }
        
    }

    /**
     * Importing existed users to predictionio.
     *
     * @return \Illuminate\View\View
     */
    public function importUsers()
    {   
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY');
        $customers = Customer::get();

        try {
            foreach($customers as $customer){
            
                $response = $client->post($url, [
                    \GuzzleHttp\RequestOptions::JSON => [
                        "event" => "\$set",
                        "entityType" => "user",
                        "entityId" => $customer->id,
                        "eventTime" => $customer->created_at
                    ] 
                ]); 
                
            }

            session()->flash('success', trans('admin::app.predictionio.users_successfully_imported') );
            return redirect()->back();   
        
        } catch (\Exception $e) {
            session()->flash('error', trans('admin::app.predictionio.unexpected_error_occured') );
            return redirect()->back();
        }
    }

}
