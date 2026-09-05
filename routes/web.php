<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class)->name('health');

Route::middleware(SecurityHeaders::class)->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('home');
    Route::post('/contact', [CompanyController::class, 'contact'])
        ->middleware('throttle:5,1')
        ->name('contact.submit');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

    Route::get('/admin/login', [AuthController::class, 'create'])
        ->middleware('guest')
        ->name('login');
    Route::post('/admin/login', [AuthController::class, 'store'])
        ->middleware(['guest', 'throttle:5,1'])
        ->name('admin.login');
    Route::post('/admin/logout', [AuthController::class, 'destroy'])
        ->middleware('auth')
        ->name('admin.logout');

    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', AdminProjectController::class)->except('show');
        Route::resource('services', AdminServiceController::class)->except('show');
        Route::resource('testimonials', AdminTestimonialController::class)->except('show');

        Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}', [AdminContactMessageController::class, 'update'])->name('messages.update');
        Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
