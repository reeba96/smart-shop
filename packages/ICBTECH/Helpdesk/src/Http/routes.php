<?php

// Main route
Route::group(['middleware' => ['web']], function () {

    Route::prefix(config('app.admin_url'))->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            
            // Active tickets
            Route::get('/tickets/active', 'ICBTECH\Helpdesk\Http\Controllers\AdministratorsController@index')->name('admin.helpdesk.index');

            Route::get('/tickets/active/show/{id}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@show')->name('admin.helpdesk.active.view');

            Route::post('/tickets/active/delete/{id}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@destroy')->name('admin.helpdesk.active.delete');

            Route::get('/tickets/active/complete/{id}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@complete')->name('admin.helpdesk.active.complete');

            // Completed tickets
            Route::get('/tickets/complete', 'ICBTECH\Helpdesk\Http\Controllers\AdministratorsController@index')->name('admin.helpdesk.index.complete'); 

            Route::get('/tickets/complete/show/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@show')->name('admin.helpdesk.complete.view');

            Route::post('/tickets/complete/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@destroy')->name("admin.helpdesk.complete.delete");

            Route::get('/tickets/complete/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@destroy')->name("admin.helpdesk.complete.delete");

            // Temporary route (comments)
            Route::get('/tickets/complete/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\TicketsController@destroy')->name("tickets-comment.store");

            // Ticket statuses admin routes
            Route::resource("/tickets/status/", 'ICBTECH\Helpdesk\Http\Controllers\StatusesController', [
                'names' => [
                    'index'   => "admin.helpdesk.status.index",
                    'store'   => "admin.helpdesk.status.store",
                    'create'  => "admin.helpdesk.status.create"
                ]
            ]);

            Route::get("/tickets/status/edit/{id?}", 'ICBTECH\Helpdesk\Http\Controllers\StatusesController@edit')->name("admin.helpdesk.status.edit");

            Route::post('/tickets/status/update/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\StatusesController@update')->name('admin.helpdesk.status.update'); 

            Route::post('/tickets/status/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\StatusesController@destroy')->name("admin.helpdesk.status.delete");
            
            Route::post('/tickets/status/massdelete', 'ICBTECH\Helpdesk\Http\Controllers\StatusesController@massDestroy')->name('admin.helpdesk.status.massdelete'); 
        
            // Ticket priorities admin routes
            Route::resource("/tickets/priority", 'ICBTECH\Helpdesk\Http\Controllers\PrioritiesController', [
                'names' => [
                    'index'   => "admin.helpdesk.priority.index",
                    'store'   => "admin.helpdesk.priority.store",
                    'create'  => "admin.helpdesk.priority.create"
                ],
            ]);

            Route::get("/tickets/priority/edit/{id?}", 'ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@edit')->name("admin.helpdesk.priority.edit");

            Route::post('/tickets/priority/update/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@update')->name('admin.helpdesk.priority.update'); 

            Route::post('/tickets/priority/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@destroy')->name("admin.helpdesk.priority.delete");
            
            Route::post('/tickets/priority/massdelete', 'ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@massDestroy')->name('admin.helpdesk.priority.massdelete'); 

            // Ticket categories madmin routes
            Route::resource("/tickets/category", 'ICBTECH\Helpdesk\Http\Controllers\CategoriesController', [
                'names' => [
                    'index'   => "admin.helpdesk.category.index",
                    'store'   => "admin.helpdesk.category.store",
                    'create'  => "admin.helpdesk.category.create"
                ],
            ]);

            Route::get("/tickets/category/edit/{id?}", 'ICBTECH\Helpdesk\Http\Controllers\CategoriesController@edit')->name("admin.helpdesk.category.edit");

            Route::post('/tickets/category/update/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\CategoriesController@update')->name('admin.helpdesk.category.update'); 

            Route::post('/tickets/category/delete/{id?}', 'ICBTECH\Helpdesk\Http\Controllers\CategoriesController@destroy')->name("admin.helpdesk.category.delete");
            
            Route::post('/tickets/category/massdelete', 'ICBTECH\Helpdesk\Http\Controllers\CategoriesController@massDestroy')->name('admin.helpdesk.category.massdelete'); 

            // Configuration routes
            Route::resource("tickets/configuration", 'ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController', [
                'names' => [
                    'index'   => "admin.helpdesk.configuration.index",
                    'update'  => "admin.helpdesk.configuration.update"
                ],
            ]);

            Route::post('/tickets/configuration/update/{id}', 'ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController@update')->name('admin.helpdesk.configuration.update'); 
            
            Route::get("/tickets/configuration/edit/{id?}", 'ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController@edit')->name("admin.helpdesk.configuration.edit");
        
            // Helpdesk reply
            Route::post('/tickets/active/show/reply', 'ICBTECH\Helpdesk\Http\Controllers\CommentsController@store')->name('admin.helpdesk.reply'); 
        });
    }); 
});
