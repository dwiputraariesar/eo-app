<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN DEPAN (HOMEPAGE) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- 2. HALAMAN DETAIL EVENT (PUBLIK) ---
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');


// --- GROUP UTAMA: USER YANG SUDAH LOGIN ---
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD REDIRECTOR ---
    Route::get('/dashboard', function () {
        $role = auth()->user()->user_type;
        if ($role === 'admin') return redirect()->route('admin.dashboard');
        elseif ($role === 'organizer') return redirect()->route('mitra.dashboard');
        else return view('dashboard'); 
    })->name('dashboard');


    // --- PROFILE ROUTES ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- 3. AREA KHUSUS ATTENDEE (PEMBELI) ---
    Route::middleware('role:attendee')->group(function () {
        // Proses Beli
        Route::post('/event/{id}/book', [BookingController::class, 'store'])->name('bookings.store');
        
        // Tiket Saya
        Route::get('/my-tickets', [BookingController::class, 'index'])->name('bookings.index');

        // Payment Flow
        Route::get('/payment/{id}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::get('/payment/{id}/success', [PaymentController::class, 'processSuccess'])->name('payment.success');
        Route::get('/payment/{id}/failed', [PaymentController::class, 'processFailed'])->name('payment.failed');
    });


    // --- 4. AREA KHUSUS ORGANIZER (MITRA) ---
    Route::middleware('role:organizer')->group(function () {
        // Dashboard
        Route::get('/mitra/dashboard', [EventController::class, 'index'])->name('mitra.dashboard');
        
        // CRUD Event
        Route::get('/mitra/events/create', [EventController::class, 'create'])->name('mitra.events.create');
        Route::post('/mitra/events', [EventController::class, 'store'])->name('mitra.events.store');
        Route::get('/mitra/events/{id}/edit', [EventController::class, 'edit'])->name('mitra.events.edit');
        Route::put('/mitra/events/{id}', [EventController::class, 'update'])->name('mitra.events.update');
        Route::delete('/mitra/events/{id}', [EventController::class, 'destroy'])->name('mitra.events.destroy');
        
        // === INI DIA YANG TADINYA HILANG (Laporan Peserta) ===
        Route::get('/mitra/events/{id}/participants', [EventController::class, 'participants'])->name('mitra.events.participants');
        
        // Halaman Penjualan
        Route::get('/mitra/sales', [EventController::class, 'sales'])->name('mitra.sales');
    });


    // --- 5. AREA KHUSUS ADMIN ---
    Route::middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User Management
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::patch('/admin/users/{id}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

        // Event Management
        Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
        Route::patch('/admin/events/{id}/update-status', [AdminController::class, 'updateEventStatus'])->name('admin.events.update-status');
        Route::delete('/admin/events/{id}', [AdminController::class, 'deleteEvent'])->name('admin.events.delete');

        // Booking & Payment Overview
        Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');

        // Category Management
        Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/admin/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
        Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::get('/admin/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
        Route::put('/admin/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    });

}); 

require __DIR__.'/auth.php';