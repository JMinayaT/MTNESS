<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::get('lang/datatable', function () {
    $lang = \App::getLocale();
    // Add locale to the cache key
    $json = \Cache::rememberForever("lang-{$lang}-datatable.json", function () {
        $lang = \App::getLocale();

        $file =  resource_path('lang/' . $lang . '/datatable.php');
        $strings = require $file;
        return $strings;
    });

    return json_encode($json);
    return $response;
});