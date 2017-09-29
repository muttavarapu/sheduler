<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Event;
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
    $id = Auth::user()->id;
    $events = App\Event::where('user_id', '=', $id)->latest()->get();
    return $events;
});

Route::middleware('auth')->post('/events', function (Request $request) {
    
    $event = new Event;
    $event->title = $request->title;
    $event->weekday = $request->day;
    $event->time = $request->time;
    $event->duration = $request->duration;
    $event->location = $request->location;
    $event->user_id = Auth::user()->id;
    Log::info('before save.', ['id' => $event->time]);
    $event->save();
        Log::info('User failed to login.', ['id' => $event->id]);
    $id = Auth::user()->id;
    $events = App\Event::where('user_id', '=', $id)->latest()->get();
    return $events;
});
Route::middleware('auth')->post('/event', function (Request $request) {
    Log::info('User failed to login.', ['id' => $request->id]);
    App\Event::where('id', '=', $request->id)->delete();
    $user_id = Auth::user()->id;
    $events = App\Event::where('user_id', '=', $user_id)->latest()->get();
    return $events;
});