<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/berita");
});
Route::get('/dashboard', function () {
    return redirect("/berita");
});
Route::get('/berita', [DashboardController::class, 'news'])->name('dashboard');
Route::get('/jadwal', [DashboardController::class, 'launches']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/bookmark', [BookmarkController::class, 'store']);
    Route::delete('/bookmark/{berita_id}', [BookmarkController::class, 'destroy']);
    Route::get('/bookmark/{berita_id}/check', [BookmarkController::class, 'checkBookmark']);
    Route::get('/bookmarks', [BookmarkController::class, 'index']);
});

require __DIR__ . '/auth.php';
