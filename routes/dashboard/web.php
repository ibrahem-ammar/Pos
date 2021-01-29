<?php

use Illuminate\Support\Facades\Route;

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
    ],function(){
    Route::prefix('dashboard')->name('dashboard.')->group(function(){

        //Dashboard routes
        Route::get('/','DashboardController@index')->name('index');
        Route::get('/index','DashboardController@index')->name('index');
        Route::resource('users', 'UserController')->except('show');
        Route::resource('categories', 'CategoryController')->except('show');
        Route::resource('products', 'ProductController')->except('show');
        Route::resource('clients', 'ClientController')->except('show');
        Route::resource('orders', 'OrderController')->except('show');

    });
});

?>
