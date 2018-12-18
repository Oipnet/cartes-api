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
Route::get('/auctions', function() {
    return \Illuminate\Support\Facades\Storage::download('auctions.csv');
})->name('auctions')->middleware('auth');
Route::get('/fixed-prices', function() {
    return \Illuminate\Support\Facades\Storage::download('fixedprices.csv');
})->name('fixedprices')->middleware('auth');

Route::get('/test', function() {
    app(\App\Http\Services\DelcampeService::class)->getNotificationConfig();
    //app(\App\Http\Services\DelcampeService::class)->setNotificationSetting('Curl_Seller_Item_Update');
});

Route::post('/endpoint/delcampe/items/update/{token}', function(\Illuminate\Http\Request $request) {
    $logfileName = storage_path().'/app/log/feedbackFromDelcampeApi' . date('Ymd') . '.log';

    if (isset($_POST['delcampeNotification'])) {
        $dataWrite = $_POST['delcampeNotification'];
    }

    $logFileHandler = fopen($logfileName, 'a');
    //chmod ($logFileHandler, 0666);
    fwrite($logFileHandler, date('H:i:s') . ' | ' . var_dump($request) . "\n");
    fclose($logFileHandler);
});
Auth::routes(['register' => false]);
