<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dont/source', [HomeController::class, 'index'])->name('dont.source');

Route::resource('/clients', ClientController::class)->except('show');
Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
Route::get('/managers/plain', [ManagerController::class, 'plainAction'])->name('managers.plain');
Route::post('/managers/plain/create', [ManagerController::class, 'plainCreate'])->name('managers.plain.create');
Route::post('/managers/get/plain', [ManagerController::class, 'getPlain']);
Route::get('/exit', [HomeController::class, 'userExit'])->name('exit');
Route::post('/manager/plain/edit', [ManagerController::class, 'plainEdit']);

Auth::routes();

