<?php

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

Route::get('/app/{vue_capture?}', function () {
 return view('vue');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');

Route::get('/', function () {
    return redirect('app');
})->middleware('auth');