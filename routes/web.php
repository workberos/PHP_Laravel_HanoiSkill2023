<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[LoginController::class, 'login']);
Route::post('/login',[LoginController::class, 'loginPost'])->name('login_post');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');



// route event
Route::resource('events', EventController::class);

// route ticket
Route::get('event/{event}/ticket/create/', [TicketController::class, 'create'])->name('ticket.create');
Route::post('event/{event}/ticket/store/', [TicketController::class, 'store'])->name('ticket.store');

// route session
Route::get('event/{event}/session/create/', [SessionController::class, 'create'])->name('session.create');
Route::post('event/{event}/session/store/', [SessionController::class, 'store'])->name('session.store');
Route::get('event/{event}/session/{session}/edit/', [SessionController::class, 'edit'])->name('session.edit');
Route::put('event/{event}/session/{session}/update/', [SessionController::class, 'update'])->name('session.update');

// route room
Route::get('event/{event}/room/create/', [RoomController::class, 'create'])->name('room.create');
Route::post('event/{event}/room/store/', [RoomController::class, 'store'])->name('room.store');


// route report
Route::get('event/{event}/report/', [RoomController::class, 'store'])->name('room.store');


Route::get('/api/v1/events', [ApiController::class, 'getEvents']);
Route::get('/api/v1/organizer/{organizer_slug}/event/{event_slug}', [ApiController::class, 'getEventDetails']);
Route::post('/api/v1/login', [ApiController::class, 'login']);
Route::post('/api/v1/logout', [ApiController::class, 'logout']);
Route::post('/api/v1/organizer/{organizer_slug}/event/{event_slug}/registration', [ApiController::class, 'registration']);
Route::post('/api/v1/registrations', [ApiController::class, 'registrationList']);










