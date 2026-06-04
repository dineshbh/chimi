<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BhutanController;
use App\Http\Controllers\AdminController;

Route::get('/', [BhutanController::class, 'home'])->name('home');
Route::get('/tours', [BhutanController::class, 'tours'])->name('tours');
Route::get('/tours/category/{slug}', [BhutanController::class, 'showCategory'])->name('tours.category');
Route::get('/tours/{slug}', [BhutanController::class, 'showTour'])->name('tours.show');
Route::get('/about/{slug?}', [BhutanController::class, 'about'])->name('about');
Route::get('/travel-info/{slug?}', [BhutanController::class, 'info'])->name('info');
Route::get('/festivals', [BhutanController::class, 'festivals'])->name('festivals');
Route::get('/gallery', [BhutanController::class, 'gallery'])->name('gallery');
Route::get('/contact', [BhutanController::class, 'contact'])->name('contact');
Route::post('/contact', [BhutanController::class, 'submitInquiry'])->name('contact.submit');

Route::get('/destinations', [BhutanController::class, 'destinations'])->name('destinations');
Route::get('/destinations/{slug}', [BhutanController::class, 'showDestination'])->name('destinations.show');
Route::get('/trekking', [BhutanController::class, 'trekking'])->name('trekking');
Route::get('/trekking/{slug}', [BhutanController::class, 'showTrek'])->name('trekking.show');
Route::get('/guide', [BhutanController::class, 'guides'])->name('guide');
Route::get('/guide/{slug}', [BhutanController::class, 'showGuide'])->name('guide.show');

Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Control Panel Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Tours CRUD
    Route::get('/tours', [AdminController::class, 'toursIndex'])->name('tours.index');
    Route::get('/tours/create', [AdminController::class, 'toursCreate'])->name('tours.create');
    Route::post('/tours', [AdminController::class, 'toursStore'])->name('tours.store');
    Route::get('/tours/{id}/edit', [AdminController::class, 'toursEdit'])->name('tours.edit');
    Route::put('/tours/{id}', [AdminController::class, 'toursUpdate'])->name('tours.update');
    Route::delete('/tours/{id}', [AdminController::class, 'toursDestroy'])->name('tours.destroy');
    
    // Pages CRUD
    Route::get('/pages', [AdminController::class, 'pagesIndex'])->name('pages.index');
    Route::get('/pages/create', [AdminController::class, 'pagesCreate'])->name('pages.create');
    Route::post('/pages', [AdminController::class, 'pagesStore'])->name('pages.store');
    Route::get('/pages/{id}/edit', [AdminController::class, 'pagesEdit'])->name('pages.edit');
    Route::put('/pages/{id}', [AdminController::class, 'pagesUpdate'])->name('pages.update');
    Route::delete('/pages/{id}', [AdminController::class, 'pagesDestroy'])->name('pages.destroy');

    // Gallery CRUD
    Route::get('/gallery', [AdminController::class, 'galleryIndex'])->name('gallery.index');
    Route::get('/gallery/create', [AdminController::class, 'galleryCreate'])->name('gallery.create');
    Route::post('/gallery', [AdminController::class, 'galleryStore'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminController::class, 'galleryDestroy'])->name('gallery.destroy');

    // Inquiry / Leads Management
    Route::get('/inquiries', [AdminController::class, 'inquiriesIndex'])->name('inquiries.index');
    Route::delete('/inquiries/{id}', [AdminController::class, 'inquiriesDestroy'])->name('inquiries.destroy');
});

require __DIR__.'/auth.php';
