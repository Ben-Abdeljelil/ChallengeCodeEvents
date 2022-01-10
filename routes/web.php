<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;

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

Route::get('/', [EventsController::class, 'showEventsList']);
Route::get('/events', [EventsController::class, 'getAllEvents']);
Route::get('/search/events', [EventsController::class, 'searchEvents'])->name('events.search');
Route::post('/events', [EventsController::class, 'setEvents']);