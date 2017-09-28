<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth')->get('/events', function (Request $request) {
    /**
     * Example content.
     */
    $id = Auth::user()->id;
    $collection = collect([
        [ 'eventId' => '1', 'title' => 'Example Title 1', 'day' => 'Friday','time' =>'253','duration'=>'55','location'=>'TravelStead Hall'],
        [ 'eventId' => '2', 'title' => 'Example Title 2', 'day' => 'Saturday','time' =>'203','duration'=>'55','location'=>'TravelStead Hall'],
        [ 'eventId' => '3', 'title' => 'Example Title 3', 'day' => 'Monday','time' =>'153','duration'=>'55','location'=>'TravelStead Hall'],
    ]);
    return $collection;
});

Route::middleware('auth')->post('/events', function (Request $request) {

    $id = Auth::user()->id;
    $collection = collect([
        [ 'eventId' => '1', 'title' =>$request->title, 'day' => $request->day,'time' =>$request->time,'duration'=>$request->duration,'location'=>$request->location],
    ]);
    return $collection;
});