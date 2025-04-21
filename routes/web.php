<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [ViewController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user-index');
        Route::get('/create', [UserController::class, 'create'])->name('user-create');
        Route::post('/store', [UserController::class, 'store'])->name('user-store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user-edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user-update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user-destroy');
        Route::get('/cities', [UserController::class, 'getCities'])->name('user.cities');
        Route::get('/kecamatan', [UserController::class, 'getKecamatan'])->name('user.kecamatan');
    });
});
