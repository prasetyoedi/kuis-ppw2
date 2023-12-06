<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [BukuController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/buku', [BukuController::class, 'index'])->name('buku');
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::get('/detail-buku/{id}', [BukuController::class, 'galbuku'])->name('galeri.buku');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::delete('/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('/buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::post('/buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::post(
            'buku/delete_galeri/{id}',
            [BukuController::class, 'galeriDestroy']
        )->name('buku.delete_galeri');
    });
    Route::post('/buku/rating/{id}', [BukuController::class, 'ratingStore'])->name('ratings.store');
    Route::match(['get', 'post'], '/buku/favorit/{id}', [BukuController::class, 'favoritStore'])->name('favorit.store');
    Route::get('/buku/myfavourite', [BukuController::class, 'favorit'])->name('buku.favorit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
