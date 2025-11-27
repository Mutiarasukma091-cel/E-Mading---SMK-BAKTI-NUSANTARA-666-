<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ArticleController as PublicArticleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Teacher\ArticleController as TeacherArticleController;
use App\Http\Controllers\Teacher\ReviewController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ArticleController as StudentArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/articles', [PublicArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [PublicArticleController::class, 'show'])->name('articles.show');
Route::get('/category/{id}', [PublicArticleController::class, 'category'])->name('articles.category');
Route::get('/search', [PublicArticleController::class, 'search'])->name('articles.search');
Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.profile');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::match(['GET', 'POST'], '/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    Route::match(['GET', 'POST'], '/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::match(['GET', 'DELETE'], '/notifications/delete-all', [NotificationController::class, 'destroyAll'])->name('notifications.delete-all');
    
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', AdminArticleController::class);
        Route::post('/articles/{id}/publish', [AdminArticleController::class, 'publish'])->name('articles.publish');
        Route::post('/articles/{id}/unpublish', [AdminArticleController::class, 'unpublish'])->name('articles.unpublish');
        Route::post('/articles/{id}/reject', [AdminArticleController::class, 'reject'])->name('articles.reject');
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/reject', [UserController::class, 'reject'])->name('users.reject');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    });
    
    // Teacher Routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', TeacherArticleController::class);
        Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
        Route::post('/review/{id}/approve', [ReviewController::class, 'approve'])->name('review.approve');
        Route::post('/review/{id}/reject', [ReviewController::class, 'reject'])->name('review.reject');
    });
    
    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', StudentArticleController::class);
    });
});

// Article like (for all users including guests)
Route::post('/articles/{id}/like', [PublicArticleController::class, 'like'])->name('articles.like');

// Article comment (only for authenticated users)
Route::middleware('auth')->group(function () {
    Route::post('/articles/{id}/comment', [PublicArticleController::class, 'comment'])->name('articles.comment');
});