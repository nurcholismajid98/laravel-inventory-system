<?php

use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Arahkan '/' ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require login)
Route::middleware('auth')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Server Inventory Route
    Route::get('/servers', [AuthController::class, 'dataServer'])->name('server.data');
});

Route::post('/server/update/{id}', [ServerController::class, 'update'])->name('server.update');
Route::delete('/server/delete/{id}', [ServerController::class, 'destroy'])->name('server.delete');
Route::post('/server/generate-qr/{id}', [ServerController::class, 'generateQrCode'])->name('server.generateQr');
Route::get('/server/view-qr/{id}', [ServerController::class, 'viewQrCode'])->name('server.viewQr');

Route::post('/server/create', [ServerController::class, 'store'])->name('server.create');

Route::get('/servers', [ServerController::class, 'index'])->name('server.data');
Route::post('/servers', [ServerController::class, 'store'])->name('servers.store');
Route::post('/servers/search', [ServerController::class, 'search'])->name('servers.search');










