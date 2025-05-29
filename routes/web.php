<?php

use App\Http\Controllers\ContactMethodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\SupportUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;

Route::get('/', [HomeController::class, 'index'])->name('home.index'); // Root route for home data

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('admin/home')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/edit', [HomeController::class, 'edit'])->name('home.edit');
    Route::put('/update', [HomeController::class, 'update'])->name('home.update');
    Route::get('/edit-button/{index}', [HomeController::class, 'editButton'])->name('home.edit.button');
    Route::put('/update-button/{index}', [HomeController::class, 'updateButton'])->name('home.update.button');
    Route::get('/edit-cta-button/{index}', [HomeController::class, 'editCtaButton'])->name('home.edit.cta.button');
    Route::put('/update-cta-button/{index}', [HomeController::class, 'updateCtaButton'])->name('home.update.cta.button');
});

Route::prefix('logo')->group(function () {
    Route::get('/', [LogoController::class, 'index'])->name('logo.index');
    Route::get('/edit', [LogoController::class, 'edit'])->name('logo.edit');
    Route::post('/update', [LogoController::class, 'update'])->name('logo.update');
});

Route::prefix('admin/contact-methods')->group(function () {
    Route::get('/', [ContactMethodController::class, 'index'])->name('contact-methods.index');
    Route::get('/create', [ContactMethodController::class, 'create'])->name('contact-methods.create');
    Route::post('/', [ContactMethodController::class, 'store'])->name('contact-methods.store');
    Route::get('/{id}/edit', [ContactMethodController::class, 'edit'])->name('contact-methods.edit');
    Route::put('/{id}', [ContactMethodController::class, 'update'])->name('contact-methods.update');
    Route::delete('/{id}', [ContactMethodController::class, 'destroy'])->name('contact-methods.destroy');
});

Route::prefix('admin/projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

Route::prefix('view/tutorials')->group(function () {
    Route::get('/', [TutorialController::class, 'index'])->name('tutorials.index');
    Route::get('/create', [TutorialController::class, 'create'])->name('tutorials.create');
    Route::post('/', [TutorialController::class, 'store'])->name('tutorials.store');
    Route::get('/{tutorial}/edit', [TutorialController::class, 'edit'])->name('tutorials.edit');
    Route::put('/{tutorial}', [TutorialController::class, 'update'])->name('tutorials.update');
    Route::delete('/{tutorial}', [TutorialController::class, 'destroy'])->name('tutorials.destroy');

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});

Route::prefix('view/supportus')->group(function () {
    Route::get('/', [SupportUsController::class, 'index'])->name('support-us.index');
    Route::get('/create', [SupportUsController::class, 'create'])->name('support-us.create');
    Route::post('/', [SupportUsController::class, 'store'])->name('support-us.store');
    Route::get('/{id}/edit', [SupportUsController::class, 'edit'])->name('support-us.edit');
    Route::put('/{id}', [SupportUsController::class, 'update'])->name('support-us.update');
    Route::delete('/{id}', [SupportUsController::class, 'destroy'])->name('support-us.destroy');
});

Route::prefix('admin/about')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('about.index');
    Route::get('/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('/', [AboutController::class, 'store'])->name('about.store');
    Route::get('/{id}/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('/{id}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/{id}', [AboutController::class, 'destroy'])->name('about.destroy');
});