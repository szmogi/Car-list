<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarControllers;
use App\Http\Controllers\PartControllers;

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

Route::get('/',  [Controller::class ,'index'])->name('welcom');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::resource('cars', CarControllers::class);
Route::resource('part', PartControllers::class);

Route::post('search', [Controller::class, 'search'])->name('search');


require __DIR__.'/auth.php';
