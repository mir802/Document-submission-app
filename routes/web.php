<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/toggle-admin/{user}', [AdminController::class, 'toggleAdmin'])->name('admin.toggleAdmin');
// Home Route
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/toggle', [UserController::class, 'toggleAdmin'])->name('admin.toggleAdmin');
    // Other admin routes...
});
Route::resource('documents', DocumentController::class)->except(['edit', 'update', 'destroy']);
Route::middleware('auth')->group(function () {
   
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    //Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('admin/documents/{document}/send-for-review', [DocumentController::class, 'sendForReview'])->name('admin.documents.sendForReview');
    // Document Routes
    Route::resource('documents', DocumentController::class)->except(['edit', 'update', 'destroy']);
    
    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/documents/{document}', [AdminController::class, 'show'])->name('admin.documents.show');
        Route::post('/documents/{document}/status', [AdminController::class, 'updateStatus'])->name('admin.documents.updateStatus');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/{user}/toggle', [UserController::class, 'toggleAdmin'])->name('admin.toggleAdmin');
    });
});