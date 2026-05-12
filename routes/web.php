<?php

use Illuminate\Support\Facades\Route;

// =========================================================================
// IMPORT SEMUA CONTROLLER & MODEL DI SINI
// =========================================================================
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SponsorOfferController;
use App\Http\Controllers\SponsorshipRequestController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\DashboardController;
use App\Models\Event;
use App\Models\SponsorOffer;
use App\Models\SponsorshipRequest;
use App\Http\Controllers\AdminController;

// =========================================================================
// 1. ROUTE PUBLIK & GUEST (Belum Login)
// =========================================================================
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth Routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

// =========================================================================
// 2. ROUTE GLOBAL AUTH (Harus Login Dulu - Akses Bebas untuk Semua Role)
// =========================================================================
Route::middleware(['auth', 'verify.account.status'])->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Notifikasi
    Route::post('/notifications/{id}/read', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->markAsRead();
        return back();
    })->name('notifications.read');
    
    Route::delete('/notifications/{id}', function ($id) {
        auth()->user()->notifications()->findOrFail($id)->delete();
        return back();
    })->name('notifications.delete');

    // Manajemen Profil
    Route::get('/profile/complete', [ProfileController::class, 'create'])->name('profile.complete');
    Route::post('/profile/complete', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/waiting-verification', [ProfileController::class, 'waitingVerification'])->name('profile.waiting_verification');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Transaksi: Pengajuan Kerjasama (Global untuk Mahasiswa & Perusahaan)
    Route::get('/request/create/{type}/{id}', [SponsorshipRequestController::class, 'create'])->name('request.create');
    Route::post('/request/store', [SponsorshipRequestController::class, 'store'])->name('request.store');
    Route::put('/request/{id}/status', [SponsorshipRequestController::class, 'updateStatus'])->name('request.update_status');
    Route::post('/request/{id}/upload-mou', [SponsorshipRequestController::class, 'uploadMoU'])->name('request.upload_mou');

    // Cetak Laporan Transaksi
    Route::get('/report', [SponsorshipRequestController::class, 'report'])->name('report.index');

    // Halaman Eksplorasi Utama (Etalase Sponsorea)
    Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');

    // Halaman Lihat Profil User Publik
    Route::get('/user/{user}/profile', [ProfileController::class, 'show'])->name('user.profile.show');

    // =========================================================================
    // 3. AREA KHUSUS PENYELENGGARA EVENT / MAHASISWA
    // =========================================================================
    Route::middleware('role:event')->group(function () {
        
        // CRUD Event Mahasiswa
        Route::get('/event/dashboard', [DashboardController::class, 'eventDashboard'])->name('event.dashboard');
        Route::get('/event/my-events', [EventController::class, 'index'])->name('event.index');
        Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/event', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
        Route::put('/event/{event}/close', [EventController::class, 'closeEvent'])->name('event.close');
        Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');

        // Transaksi Mahasiswa
        Route::get('/event/requests', [SponsorshipRequestController::class, 'outgoingEvent'])->name('event.requests');
        Route::get('/event/incoming', [SponsorshipRequestController::class, 'incomingEvent'])->name('event.incoming');
    });


    // =========================================================================
    // 4. AREA KHUSUS PERUSAHAAN / SPONSOR
    // =========================================================================
    Route::middleware('role:company')->group(function () {
        
        // CRUD Penawaran Sponsor
        Route::get('/company/dashboard', [DashboardController::class, 'companyDashboard'])->name('company.dashboard');
        Route::get('/company/offers', [SponsorOfferController::class, 'index'])->name('company.index');
        Route::get('/company/offer/create', [SponsorOfferController::class, 'create'])->name('sponsor-offer.create');
        Route::post('/company/offer', [SponsorOfferController::class, 'store'])->name('sponsor-offer.store');
        Route::get('/company/offer/{sponsorOffer}/edit', [SponsorOfferController::class, 'edit'])->name('sponsor-offer.edit');
        Route::put('/company/offer/{sponsorOffer}', [SponsorOfferController::class, 'update'])->name('sponsor-offer.update');
        Route::put('/company/offer/{sponsorOffer}/close', [SponsorOfferController::class, 'closeOffer'])->name('sponsor-offer.close');
        Route::delete('/company/offer/{sponsorOffer}', [SponsorOfferController::class, 'destroy'])->name('sponsor-offer.destroy');

        // Transaksi Perusahaan
        Route::get('/company/requests', [SponsorshipRequestController::class, 'outgoingCompany'])->name('company.requests');
        Route::get('/company/incoming', [SponsorshipRequestController::class, 'incomingCompany'])->name('company.incoming_requests');
    });


    // =========================================================================
    // 5. AREA KHUSUS SUPER ADMIN
    // =========================================================================
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Dashboard Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Manajemen Verifikasi Akun
    Route::get('/verifications', [AdminController::class, 'verifications'])->name('admin.verifications');
    Route::put('/verifications/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.user.approve');
    Route::put('/verifications/{user}/reject', [AdminController::class, 'rejectUser'])->name('admin.user.reject');
    
    // Manajemen Kategori (Event & Funding)
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/event-types', [AdminController::class, 'storeEventType'])->name('admin.event-types.store');
    Route::put('/event-types/{id}', [AdminController::class, 'updateEventType'])->name('admin.event-types.update');
    Route::delete('/event-types/{id}', [AdminController::class, 'destroyEventType'])->name('admin.event-types.destroy');
    Route::post('/funding-types', [AdminController::class, 'storeFundingType'])->name('admin.funding-types.store');
    Route::put('/funding-types/{id}', [AdminController::class, 'updateFundingType'])->name('admin.funding-types.update');
    Route::delete('/funding-types/{id}', [AdminController::class, 'destroyFundingType'])->name('admin.funding-types.destroy');
    
    });

});