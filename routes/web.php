<?php


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['namespace' => 'front', 'middleware' => ['auth']],function(){

    Route::group(['namespace' => 'profil', 'as' => 'profil.', 'prefix' => 'profil'],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::post('/', 'indexController@update')->name('update');
    });

    Route::group(['namespace' => 'home', 'as' => 'home.'],function (){
        Route::get('/', 'indexController@index')->name('index');
    });

    Route::group(['namespace' => 'musteriler', 'as' => 'musteriler.', 'prefix' => 'musteriler', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::get('/extre/{id}', 'indexController@extre')->name('extre');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'urun', 'as' => 'urun.', 'prefix' => 'urun', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'kalem', 'as' => 'kalem.', 'prefix' => 'kalem', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'fatura', 'as' => 'fatura.', 'prefix' => 'fatura', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur/{type}', 'indexController@create')->name('create');
        Route::post('/olustur/{type}', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'banka', 'as' => 'banka.', 'prefix' => 'banka', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'islem', 'as' => 'islem.', 'prefix' => 'islem', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur/{type}', 'indexController@create')->name('create');
        Route::post('/olustur/{type}', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

    Route::group(['namespace' => 'user', 'as' => 'user.', 'prefix' => 'user', 'middleware' => ['PermissionControl']],function (){
        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/delete/{id}', 'indexController@delete')->name('delete');
        Route::post('/data', 'indexController@data')->name('data');
    });

});
