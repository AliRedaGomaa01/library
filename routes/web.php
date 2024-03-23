<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // return inertia('Landing');
    return to_route('books.index');
})->name('landing');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';


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
        Route::get('/', 'index')->withoutMiddleware('auth')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{tag}', 'destroy')->name('destroy');
    });

    Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{book:id}/{type?}', 'store')->name('store');
        Route::patch('/{order:id}/reverse', 'reverse')->name('reverse');
        Route::patch('/{order}/{status}', 'update')->name('update');
        Route::delete('/{book:id}', 'destroy')->name('destroy');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/rejected', 'rejected')->name('rejected');
        Route::get('/borrowed', 'borrowed')->name('borrowed');
        Route::get('/reversed', 'reversed')->name('reversed');
    });

});


// Route::get('/', function () {
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
// });