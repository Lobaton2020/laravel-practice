<?php

use App\Http\Procedures\SalasProcedure;
use Illuminate\Support\Facades\Route;
use App\Http\Procedures\TennisProcedure;

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

Route::get("v1/and", function () {
    return ["Hola" => "sdsdsd"];
});
Route::rpc('/rpc', [SalasProcedure::class])->name('rpc.endpoint');