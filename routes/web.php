<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\BikeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Mapa:
Route::get('/mapa', 'App\Http\Controllers\MapController@show')->middleware(['auth'])->name('mapa');
Route::post('/mapa/add', 'App\Http\Controllers\MapController@add');

Route::get('/bikes', 'App\Http\Controllers\BikeController@show')->middleware(['auth'])->name('bikes');

require __DIR__.'/auth.php';
