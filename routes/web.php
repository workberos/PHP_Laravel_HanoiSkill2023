<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EventController;
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
Route::get('/ticket/create/{event}', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/ticket/store/{event}', [TicketController::class, 'store'])->name('tickets.store');



