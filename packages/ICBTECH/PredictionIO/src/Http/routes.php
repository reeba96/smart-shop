<?php
Route::group(['middleware' => ['web', 'admin']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {

        // Users
        Route::get('predictionio/users', 'ICBTECH\PredictionIO\Http\Controllers\UsersController@index')->name('admin.predictionio.users');

        // Import existing users
        Route::get('predictionio/importUsers', 'ICBTECH\PredictionIO\Http\Controllers\UsersController@importUsers')->name('admin.predictionio.importUsers');

        // Items
        Route::get('predictionio/items', 'ICBTECH\PredictionIO\Http\Controllers\ItemsController@index')->name('admin.predictionio.items');

        // Import existing items
        Route::get('predictionio/importItems', 'ICBTECH\PredictionIO\Http\Controllers\ItemsController@importItems')->name('admin.predictionio.importItems');
        
        // Views
        Route::get('predictionio/views', 'ICBTECH\PredictionIO\Http\Controllers\ViewsController@index')->name('admin.predictionio.views');

        // Import existing views
        Route::get('predictionio/importViews', 'ICBTECH\PredictionIO\Http\Controllers\ViewsController@importViews')->name('admin.predictionio.importViews');

        // Delete views from table
        Route::get('predictionio/deleteViews', 'ICBTECH\PredictionIO\Http\Controllers\ViewsController@delete')->name('admin.predictionio.deleteViews');

        // Purchases
        Route::get('predictionio/purchases', 'ICBTECH\PredictionIO\Http\Controllers\PurchasesController@index')->name('admin.predictionio.purchases');

        // Import existing purchases
        Route::get('predictionio/importPurchases', 'ICBTECH\PredictionIO\Http\Controllers\PurchasesController@importPurchases')->name('admin.predictionio.importPurchases');

        // Settings
        Route::get('predictionio/settings', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@index')->name('admin.predictionio.settings');

        // Start
        Route::post('predictionio/start', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@start')->name('admin.predictionio.start');

        // Build
        Route::get('predictionio/build', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@build')->name('admin.predictionio.build');

        // Train
        Route::get('predictionio/train', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@train')->name('admin.predictionio.train');

        // Deploy
        Route::get('predictionio/deploy', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@deploy')->name('admin.predictionio.deploy');
        
        // Delete
        Route::get('predictionio/delete', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@delete')->name('admin.predictionio.delete');

        // Recommend
        Route::post('predictionio/recommend', 'ICBTECH\PredictionIO\Http\Controllers\SettingsController@recommend')->name('admin.predictionio.recommend');
    });
});