<?php

Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
    ],function(){
    Route::get('/','DashboardController@index');
    Route::prefix('dashboard')->name('dashboard.')->group(function(){

        //Dashboard routes
        Route::get('/index','DashboardController@index')->name('index');
        Route::resource('users', 'UserController')->except('show');
        Route::resource('categories', 'CategoryController')->except('show');
        Route::resource('products', 'ProductController')->except('show');
        Route::resource('clients', 'ClientController')->except('show');

    });
});

?>
