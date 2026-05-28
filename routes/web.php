<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Livewire\Dashboard;
use App\Livewire\Seller\Edit;
use App\Livewire\Seller\Index;
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

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/clients', ClientController::class);
    Route::get('/sales', [SaleController::class, 'index']);

    Route::get('/sellers', Index::class)->name('sellers.index');
    Route::get('/sellers/create', Edit::class)->name('sellers.create');
    Route::get('/sellers/{seller}/edit', Edit::class)->name('sellers.edit');

    Route::get('/impersonate/{userId}/login', [ImpersonateController::class, 'impersonate'])->name('impersonate');
    Route::get('/impersonate/leave', [ImpersonateController::class, 'leaveImpersonate'])->name('impersonate.leave');
});

require __DIR__.'/auth.php';
