<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller;
use ICBTECH\PredictionIO\Models\Views;
use GuzzleHttp\Exception\GuzzleException;
use ICBTECH\PredictionIO\Jobs\importViewsJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

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
            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY')."&event=view&entityType=user&limit=".env('PREDICTIONIO_QUERY_LIMIT');
            $response = $client->get($url);
            $entities = json_decode($response->getBody()->getContents());

            return view('predictionio::admin.views', compact('entities'));

        } catch (\Exception $e) {
            \Log::info($e);
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
        importViewsJob::dispatch()->onQueue('importViews');

        session()->flash('success', trans('admin::app.predictionio.views_successfully_imported') );
        
        return redirect()->back();
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
