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

/*Route::get('/zomoto', function () {
    return view('welcome');
});
*/

Route::get('/vishvesh', function () {
    return view('main');
});

Route::get('/vishvesh/login', function () {
    return view('login');
});

Route::get('/vishvesh/order', function () {
    return view('order');
});
Route::get('/vishvesh/order/{fid}', 'OrdersController@postFromUI');

/*Route::get('/vishvesh/order/{fid}', function () {
    return view('order', ['fid' =>  $fid]);
});*/

Route::get('/ajax', function () {
    return view('message');
});

Route::post('/loginn','SessionController@getData');
Route::get('/session/get','SessionController@accessSessionData');
Route::get('/session/set','SessionController@storeSessionData');
Route::get('/session/remove','SessionController@deleteSessionData');

Route::get('/trail', function () {
    return view('sample');
});
Route::post('/getmsg', 'AjaxController@index');
