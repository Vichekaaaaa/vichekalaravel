<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactMethodController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\SupportUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;

// Home Data
Route::get('/home', [HomeController::class, 'index']);
Route::post('/home/cta-buttons/{index}', [HomeController::class, 'updateCtaButtonApi']);

// Contact Methods
Route::get('/contact-methods', [ContactMethodController::class, 'index']);

// Projects
Route::apiResource('projects', ProjectController::class, [
    'only' => ['index', 'store', 'show', 'update', 'destroy']
]);

// Tutorials
Route::get('/tutorials', [TutorialController::class, 'apiIndex']);

// Categories
Route::get('/categories', [CategoryController::class, 'apiIndex']);
Route::post('/categories', [CategoryController::class, 'apiStore']);

// Logo
Route::get('/logo', [LogoController::class, 'getLogo']);

// Support Us
Route::get('/support-us', [SupportUsController::class, 'apiIndex']);

// About
Route::get('/about', [AboutController::class, 'apiIndex']);