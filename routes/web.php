<?php

use App\Http\Controllers\ReimburseController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ReimburseController::class, 'index'])->name('landing');

Route::get('/print', [ReimburseController::class, 'print'])->name('print');