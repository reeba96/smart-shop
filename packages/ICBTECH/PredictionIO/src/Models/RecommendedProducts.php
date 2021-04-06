<?php

namespace ICBTECH\PredictionIO\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendedProducts extends Model
{
    protected $table = 'recommended_products';

    protected $fillable = [
        'customer_id',
        'product_id',
        'score'
    ];

}