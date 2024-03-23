<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return inertia('Landing');
})->name('landing');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(BookController::class)->prefix('books')->name('books.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::get('/', 'index')->withoutMiddleware('auth')->name('index');
        Route::get('/{book}', 'show')->withoutMiddleware('auth')->name('show');
        Route::post('/', 'store')->name('store');
        Route::get('/{book}/edit', 'edit')->name('edit');
        Route::put('/{book}', 'update')->name('update');
        Route::delete('/{book}', 'destroy')->name('destroy');
    });
    
    Route::controller(TagController::class)->prefix('tags')->name('tags.')->group(function () {
        Route::get('/', 'index')->withoutMiddleware('auth')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::delete('/{tag}', 'destroy')->name('destroy');
    });

});

require __DIR__.'/auth.php';

Route::controller(BookController::class)->prefix('books')->name('books.')->group(function () {
    Route::get('/', 'index')->name('index');
});


// Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
// });