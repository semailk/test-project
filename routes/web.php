<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ManagerController;
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

Route::resource('/clients', ClientController::class)->except('show');
Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
