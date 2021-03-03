<?php

Route::group(['prefix' => 'api/admin','namespace' => 'ICBTECH\Bodywave\Http\Controllers\Api'], function ($router) {
    Route::post('login', 'APILoginController@login');

    Route::middleware('jwt.auth')->post('syncProduct', 'ProductController@sync');

});




Route::group(['prefix' => 'api/bodywave/','middleware' => ['web', 'admin'],'namespace' => 'ICBTECH\Bodywave\Http\Controllers\Api'], function () {

    Route::get('/syncProduct', 'ProductController@index')->defaults('_config', [
        'view' => 'bodywave::admin.product.index',
    ])->name('bodywave.admin.index');


});