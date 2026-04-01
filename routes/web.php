<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProposalController as AdminProposalController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\Admin\ClientPortalController as AdminClientPortalController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/proposal', [PageController::class, 'proposal'])->name('proposal');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/page/{page:slug}', [PageController::class, 'show'])->name('page.show');
Route::get('/team-option/{option}', [PageController::class, 'teamOption'])->name('team.option')->where('option', '[1-5]');
Route::post('/proposal', [ProposalController::class, 'submit'])->name('proposal.submit');
Route::post('/contact', [ProposalController::class, 'contact'])->name('contact.submit');

// Client Portal routes (public)
Route::prefix('client-portal')->name('client-portal.')->group(function () {
    Route::get('/', [ClientPortalController::class, 'showRequestForm'])->name('request');
    Route::post('/request-link', [ClientPortalController::class, 'requestLink'])->name('request-link')->middleware('throttle:5,1');
    Route::get('/access/{token}', [ClientPortalController::class, 'access'])->name('access');
    Route::get('/dashboard', [ClientPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/download/{file}', [ClientPortalController::class, 'downloadFile'])->name('download');
    Route::post('/upload', [ClientPortalController::class, 'uploadFiles'])->name('upload');
    Route::get('/logout', [ClientPortalController::class, 'logout'])->name('logout');
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::delete('/pages/{page}/image/{location?}', [AdminPageController::class, 'destroyImage'])->name('pages.destroy-image');
        Route::resource('team', TeamMemberController::class)->except(['show']);
        Route::post('/team/reorder', [TeamMemberController::class, 'reorder'])->name('team.reorder');
        Route::put('/team/section-title', [TeamMemberController::class, 'updateSectionTitle'])->name('team.update-section-title');
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::post('/services/reorder', [ServiceController::class, 'reorder'])->name('services.reorder');
        Route::resource('achievements', AchievementController::class)->except(['show']);
        Route::post('/achievements/reorder', [AchievementController::class, 'reorder'])->name('achievements.reorder');
        Route::get('/images', [SiteImageController::class, 'index'])->name('images.index');
        Route::get('/images/{location}/edit', [SiteImageController::class, 'edit'])->name('images.edit');
        Route::put('/images/{location}', [SiteImageController::class, 'update'])->name('images.update');
        Route::delete('/images/{location}', [SiteImageController::class, 'destroy'])->name('images.destroy');
        Route::get('/activity', [ActivityLogController::class, 'index'])->name('activity.index');
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
        Route::get('/proposals/{proposal}', [AdminProposalController::class, 'show'])->name('proposals.show');
        Route::put('/proposals/{proposal}', [AdminProposalController::class, 'update'])->name('proposals.update');
        Route::delete('/proposals/{proposal}', [AdminProposalController::class, 'destroy'])->name('proposals.destroy');

        Route::get('/settings', [SiteSettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');

        // Client Portals
        Route::resource('client-portals', AdminClientPortalController::class);
        Route::post('/client-portals/{clientPortal}/upload', [AdminClientPortalController::class, 'uploadFiles'])->name('client-portals.upload');
        Route::delete('/client-portals/{clientPortal}/files/{file}', [AdminClientPortalController::class, 'deleteFile'])->name('client-portals.delete-file');
        Route::get('/client-portals/{clientPortal}/files/{file}/download', [AdminClientPortalController::class, 'downloadFile'])->name('client-portals.download');
        Route::post('/client-portals/{clientPortal}/send-link', [AdminClientPortalController::class, 'sendMagicLink'])->name('client-portals.send-link');
    });

// User routes (from Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
