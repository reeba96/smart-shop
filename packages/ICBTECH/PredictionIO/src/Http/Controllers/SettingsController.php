<?php

namespace ICBTECH\PredictionIO\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webkul\Customer\Models\Customer;
use Symfony\Component\Process\Process;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use ICBTECH\PredictionIO\Jobs\recommendProductsJob;
use ICBTECH\PredictionIO\Models\RecommendedProducts;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SettingsController extends Controller
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
        return view('predictionio::admin.settings');
    }

    /**
     * Call console command for starting
     *
     * @return \Illuminate\View\View
     */
    public function start()
    {   
        $process = new Process(['/home/pio/PredictionIO-0.14.0/bin/pio-start-all']);

        // $process->setWorkingDirectory('/home/pio/PredictionIO-0.14.0/bin');

        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            \Log::info(new ProcessFailedException($process));

            session()->flash('error', 'Failed' );

            return back()->with('status', 'Failed' );
        }
        
        \Log::info($process->getOutput());

        session()->flash('success', 'Started');

        return back()->with('status', 'Started');
    }


    /**
     * Call console command for building
     *
     * @return \Illuminate\View\View
     */
    public function build()
    {   
        $process = new Process(['pio', 'build', '--verbose']);

        $process->setWorkingDirectory('/home/albert/Projects/predictionio/SmartShopECommerceRecommendation/');

        // $process->run();
        $process->run(null, ['PATH' => '/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/usr/games:/usr/local/games:/snap/bin:/home/albert/Projects/predictionio/PredictionIO-0.14.0/bin']);

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            \Log::info(new ProcessFailedException($process));

            session()->flash('error', trans('admin::app.predictionio.building_failed') );

            return back()->with('status', trans('admin::app.predictionio.building_failed') );
        }
        
        \Log::info($process->getOutput());

        session()->flash('success', trans('admin::app.predictionio.building_successfully_completed'));

        return back()->with('status', trans('admin::app.predictionio.building_successfully_completed'));
    }

     /**
     * Call console command for training
     *
     * @return \Illuminate\View\View
     */
    public function train()
    {
        $process = new Process(['pio train', '/home/albert/Projects/predictionio/SmartShopECommerceRecommendation/']);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            \Log::info(new ProcessFailedException($process));

            session()->flash('error', trans('admin::app.predictionio.training_failed') );

            return back()->with('status', trans('admin::app.predictionio.training_failed') );
        }

        \Log::info($process->getOutput());

        session()->flash('success', trans('admin::app.predictionio.training_successfully_completed'));

        return back()->with('status', trans('admin::app.predictionio.training_successfully_completed'));
    }

     /**
     * Call console command for deploying
     *
     * @return \Illuminate\View\View
     */
    public function deploy()
    {
        $process = new Process(['pio deploy', '/home/albert/Projects/predictionio/SmartShopECommerceRecommendation/']);

        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            \Log::info(new ProcessFailedException($process));

            session()->flash('error', trans('admin::app.predictionio.deploying_failed') );

            return back()->with('status', trans('admin::app.predictionio.deploying_failed') );
        }

        \Log::info($process->getOutput());

        session()->flash('success', trans('admin::app.predictionio.deploying_successfully_completed'));

        return back()->with('status', trans('admin::app.predictionio.deploying_successfully_completed'));

    }

    /**
     * Call console command for building
     *
     * @return \Illuminate\View\View
     */
    public function delete()
    {
        $process = new Process(['pio app data-delete SmartShop', '/home/albert/Projects/predictionio/SmartShopECommerceRecommendation/']);

        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            \Log::info(new ProcessFailedException($process));

            session()->flash('error', trans('admin::app.predictionio.deleting_failed') );

            return back()->with('status', trans('admin::app.predictionio.deleting_failed') );
        }

        \Log::info($process->getOutput());

        session()->flash('success', trans('admin::app.predictionio.deleting_successfully_completed'));

        return back()->with('status', trans('admin::app.predictionio.deleting_successfully_completed'));
    }

    /**
     * Recommend products to users
     *
     * @return \Illuminate\View\View
     */
    public function recommend(Request $request)
    {   
        dd($request);
        $recommended_product_number = (int)$request->product_number;

        recommendProductsJob::dispatch(['recommended_product_number' => $recommended_product_number])->onQueue('recommendProducts');

        session()->flash('success', trans('admin::app.predictionio.successfully_recommended') );
        
        return redirect()->back();

    }
}
