<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PostManagementController;

Route::get('/', function () {return redirect('/posts/latest');});
Route::get('/posts/search', [App\Http\Controllers\PostController::class, 'search'])->name('posts.search');

 // Postingan
    Route::get('/posts/popular', [PostController::class, 'popular'])->name('posts.popular');
    Route::get('/posts/latest', [PostController::class, 'latest'])->name('posts.latest');
    Route::get('/posts/images', [PostController::class, 'images'])->name('posts.images');
    Route::get('/posts/music', [PostController::class, 'music'])->name('posts.music');
    Route::get('/posts/videos', [PostController::class, 'videos'])->name('posts.videos');
    Route::get('/posts/docs', [PostController::class, 'docs'])->name('posts.docs');
    Route::get('/rules', function () {return view('rules');})->name('rules');

// Semua route yang butuh login
Route::middleware('auth')->group(function () {
    // Admin Menu
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/posts', [PostManagementController::class, 'index'])->name('admin.posts.index');
    Route::delete('/admin/posts/{id}', [PostManagementController::class, 'destroy'])->name('admin.posts.destroy');

    // Profil & Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('posts', PostController::class)->except(['create', 'store', 'index']);

    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Upload Postingan
    Route::get('/upload', [PostController::class, 'create'])->name('posts.upload');
    Route::post('/upload', [PostController::class, 'store'])->name('posts.store');

    // Like & Comment
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
    Route::post('/posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('posts.comments.reply');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    // Download Dokumen & Preview
    Route::get('/posts/{id}/download', [PostController::class, 'download'])->name('posts.download');
    Route::get('/posts/{id}/preview', [PostController::class, 'preview'])->name('posts.preview');


});

require __DIR__.'/auth.php';