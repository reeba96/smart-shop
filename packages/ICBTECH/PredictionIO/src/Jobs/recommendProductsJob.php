<?php

namespace ICBTECH\PredictionIO\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Models\Product;
use Webkul\Customer\Models\Customer;
use ICBTECH\PredictionIO\Models\Views;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use ICBTECH\PredictionIO\Models\RecommendedProducts;
use Symfony\Component\Process\Exception\ProcessFailedException;

class recommendProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recommended_product_number = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->recommended_product_number = $data["recommended_product_number"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        try {
            $customers = Customer::get();
            \Log::info("ITT LOG: " . $this->recommended_product_number);
            RecommendedProducts::truncate();

            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $url = env('PREDICTIONIO_RECOMMEND_URL')."/queries.json";
            
            $product_number = $this->recommended_product_number;
            
            foreach($customers as $customer){
            
                $response = $client->post($url, [
                    \GuzzleHttp\RequestOptions::JSON => [
                        "user" => $customer->id,
                        "num" => $product_number
                    ] 
                ]); 

                $recommended_products = (array)json_decode($response->getBody()->getContents());
                
                foreach($recommended_products["itemScores"] as $recommended_product){
                    
                    RecommendedProducts::create([
                        'customer_id' => $customer->id,
                        'product_id' => $recommended_product->item,
                        'score' => $recommended_product->score
                    ]);
                   
                }
            } 
        
        } catch (\Exception $e) {
            \Log::info($e);
        }
        
    }
}