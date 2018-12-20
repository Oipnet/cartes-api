<?php

use Orchestra\Parser\Xml\Facade as XmlParser;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController')->middleware('auth');

Route::get('/configuration/notification', 'Configuration\\ListNotificationController')->name('notification_index')->middleware('auth');
Route::delete('/configuration/notification/{id}', 'Configuration\\DeleteNotificationController')->name('notification_delete')->middleware('auth');
Route::get('/configuration/notification/{id}', 'Configuration\\UpdateNotificationController')->name('notification_edit')->middleware('auth');
Route::put('/configuration/notification/{id}', 'Configuration\\UpdateNotificationController')->name('notification_update')->middleware('auth');

Route::get('/items', 'Item\\ListItemController')->name('item_index')->middleware('auth');
Route::get('/items/{id}', 'Item\\UpdateItemController')->name('item_edit')->middleware('auth');
Route::put('/items/{id}', 'Item\\UpdateItemController')->name('item_update')->middleware('auth');

Route::get('/categories', function() {
    return Cache::get('categories', function() {
        return (new \App\Http\Resources\Categories(\App\Category::whereNull('id_parent')->get()))->response();
    });
});

Route::get('/auctions', function() {
    return \Illuminate\Support\Facades\Storage::download('auctions.csv');
})->name('auctions')->middleware('auth');
Route::get('/fixed-prices', function() {
    return \Illuminate\Support\Facades\Storage::download('fixedprices.csv');
})->name('fixedprices')->middleware('auth');

Route::get('/test', function() {

});

Route::get('/test2', function () {

});

Route::post('/endpoint/delcampe/items/update/{token}', 'Endpoints\\Delcampe\\SellerItemUpdateEndpointController');

Auth::routes(['register' => false]);
