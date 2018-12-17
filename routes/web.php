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

Route::get('/', 'HomeController');
Route::get('/auctions', function() {
    return \Illuminate\Support\Facades\Storage::download('auctions.csv');
})->name('auctions');
Route::get('/fixed-prices', function() {
    return \Illuminate\Support\Facades\Storage::download('fixedprices.csv');
})->name('fixedprices');