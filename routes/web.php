<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNodeController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('/notes', NoteController::class)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function () {
    Route::get('/', [TrashedNodeController::class, 'index'])->name('index');
    Route::get('/{note}', [TrashedNodeController::class, 'show'])->withTrashed()->name('show');
    Route::put('/{note}', [TrashedNodeController::class, 'update'])->withTrashed()->name('update');
    Route::delete('/{note}', [TrashedNodeController::class, 'destroy'])->withTrashed()->name('destroy');
});

require __DIR__ . '/auth.php';
