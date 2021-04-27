<?php

namespace ICBTECH\PredictionIO\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;

class importPurchasesJobs implements ShouldQueue
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

            $url = env('PREDICTIONIO_URL').'/events.json?accessKey='.env('PREDICTIONIO_ACCESS_KEY');
                
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
        
        } catch (\GuzzleException $e) {
            \Log::info($e);
        }
    }
}