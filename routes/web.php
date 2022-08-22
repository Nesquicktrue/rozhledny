<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;

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

Route::get('/mapa', 'App\Http\Controllers\MapController@show')->middleware(['auth'])->name('mapa');

//Route::get('/mapa/add', 'App\Http\Controllers\MapController@add')->middleware(['auth'])->name('add');
Route::post('/mapa/add', 'App\Http\Controllers\MapController@add');

require __DIR__.'/auth.php';
