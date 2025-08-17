<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConfessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;




// Landing page or homepage for anonymous users
Route::get('/', function () {
    return redirect()->route('confessions.index');
});

// Show login form (normal) and (admin-mode)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->name('admin.login');

Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');


// Admin routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'editUsers'])->name('editUsers');
    Route::get('/posts', [AdminController::class, 'editPosts'])->name('editPosts');
    Route::get('/comments', [AdminController::class, 'editComments'])->name('editComments');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('deleteUser');
    Route::delete('/comments/{comment}', [AdminController::class, 'deleteComment'])->name('deleteComment');
    Route::delete('/posts/{post}', [AdminController::class, 'deletePost'])->name('deletePost');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('toggleAdmin');
    Route::post('/confessions/{confession}/ignore-report', [AdminController::class, 'ignoreReport'])->name('ignoreReport');
    Route::post('/comments/{comment}/ignore', [AdminController::class, 'ignoreCommentReport'])->name('ignoreCommentReport');
});


// Regular user dashboard route
Route::get('/dashboard', function () {
    return redirect()->route('confessions.index');
})->middleware('auth')->name('dashboard');

// Protected routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registration routes
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Confession routes
Route::get('/confess', [ConfessionController::class, 'create'])->name('confessions.create');
Route::post('/confess', [ConfessionController::class, 'store'])->name('confessions.store');
Route::get('/confessions', [ConfessionController::class, 'index'])->name('confessions.index'); // View confessions
Route::get('/confessions/{id}', [ConfessionController::class, 'show'])->name('confessions.show');

// Comment routes
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/comments/{comment}/report', [CommentController::class, 'report'])->name('comments.report')->middleware('auth');

Route::get('/moods/search/{mood}', [MoodController::class, 'search'])->name('moods.search');


// Upvote and report routes
Route::post('/confessions/{id}/upvote', [ConfessionController::class, 'upvote'])->name('confessions.upvote');
Route::post('/confessions/{id}/report', [ConfessionController::class, 'report'])->name('confessions.report');


Route::get('/trending', [ConfessionController::class, 'trending'])->name('confessions.trending');


// Additional auth routes (password resets, etc.)
require __DIR__ . '/auth.php';
