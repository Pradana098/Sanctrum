<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rute untuk mendapatkan pengguna yang terautentikasi
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk Mahasiswa dengan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('mahasiswas', MahasiswaController::class);
});

// Rute untuk registrasi dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('mahasiswas', [MahasiswaController::class, 'getAllData']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('mahasiswa')->group(function () {
    Route::post('/', [MahasiswaController::class, 'store']); // Create
    Route::get('/', [MahasiswaController::class, 'index']);  // Get All
    Route::get('{id}', [MahasiswaController::class, 'show']); // Get Single
    Route::put('{id}', [MahasiswaController::class, 'update']); // Update
    Route::delete('{id}', [MahasiswaController::class, 'destroy']); // Delete
});