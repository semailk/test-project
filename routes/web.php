<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepositController;
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

Auth::routes();

Route::middleware('auth')->group(function (){
    // Роуты для менеджаров
    Route::prefix('managers')->group(function (){
        Route::get('', [ManagerController::class, 'index'])->name('managers.index');
        Route::get('plain', [ManagerController::class, 'plainAction'])->name('managers.plain');
        Route::post('plain/create', [ManagerController::class, 'plainCreate'])->name('managers.plain.create');
        Route::post('get/plain', [ManagerController::class, 'getPlain']);
        Route::get('exit', [HomeController::class, 'userExit'])->name('exit');
        Route::post('plain/edit', [ManagerController::class, 'plainEdit']);
    });

    // Роуты для депозитов
    Route::prefix('deposits')->group(function (){
        Route::get('', [DepositController::class, 'index'])->name('deposits');
        Route::get('{client}', [DepositController::class, 'create'])->name('deposits.show');
        Route::get('exchange/{client}', [DepositController::class, 'exchangeDeposit'])->name('deposits.exchange');
        Route::post('store', [DepositController::class, 'store'])->name('deposits.store');
        Route::post('withdraw', [DepositController::class, 'withdrawT'])->name('withdraw');
        Route::get('/pdf/store/{id}', [DepositController::class, 'pdfStore'])->name('pdf.store');
    });
});

