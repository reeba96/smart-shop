<?php
Route::group(['middleware' => ['web', 'admin']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {

        Route::get('predictionio/users', 'ICBTECH\PredictionIO\Http\Controllers\UsersController@index')->name('admin.predictionio.users');

        Route::get('predictionio/items', 'ICBTECH\PredictionIO\Http\Controllers\ItemsController@index')->name('admin.predictionio.items');

        Route::get('predictionio/views', 'ICBTECH\PredictionIO\Http\Controllers\ViewsController@index')->name('admin.predictionio.views');

        Route::get('predictionio/purchases', 'ICBTECH\PredictionIO\Http\Controllers\PurchasesController@index')->name('admin.predictionio.purchases');

        Route::get('predictionio/settings', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@index')->name('admin.predictionio.settings');
    });
});