<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
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
            $url = env('PREDICTIONIO_URL').env('PREDICTIONIO_ACCESS_KEY');
            $response = $client->get($url);
            $entities = json_decode($response->getBody()->getContents());

            return view('predictionio::admin.items', compact('entities'));

        } catch (GuzzleException $exception) {
            session()->flash('error', trans('shop::app.customer.signup-form.failed'));

            return redirect()->back();
        }
    }

}
