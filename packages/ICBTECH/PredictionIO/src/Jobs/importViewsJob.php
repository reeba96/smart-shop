<?php

namespace ICBTECH\PredictionIO\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use ICBTECH\PredictionIO\Models\Views;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;

class importViewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
        
        } catch (\Exception $e) {
            \Log::info($e);
        }
    }
}