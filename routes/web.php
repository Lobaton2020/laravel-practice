<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SalaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function (){
    return redirect("/salas");
});
Route::resource('salas', SalaController::class);
Route::get('/salas/{id}/eventos', [EventController::class, 'eventos']);
