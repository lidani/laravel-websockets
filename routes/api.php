<?php

use App\Events\MyEvent;
use App\User;
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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', 'AuthController@register');
Route::post('/user/{id}', 'AuthController@change');

Route::get('/users', function (Request $request) {
    return response()->json(User::all(['id', 'name', 'email']));
});

Route::post('/testpusher', function () {
    return event(new MyEvent('Hello, World!'));
});
