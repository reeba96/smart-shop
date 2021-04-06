<?php

namespace ICBTECH\PredictionIO\Models;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    protected $table = 'views';

    protected $fillable = [
        'customer_id',
        'product_id'
    ];

}