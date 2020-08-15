<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function()
{


    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
   
        Route::get('/index','DashboardController@index')->name('index');


        // user routes

        Route::resource('users', 'UserController')->except(['show']);

        
        // category routes

        Route::resource('categories', 'CategoryController')->except(['show']);

                
        // products routes

        Route::resource('products', 'ProductController')->except(['show']);

        // orders routes

        Route::resource('orders', 'OrderController')->except(['show']);
        Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');


        // clients routes

        Route::resource('clients', 'ClientController')->except(['show']);
        Route::resource('clients.orders', 'Client\OrderController');

        
    });



});