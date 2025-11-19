<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');
Route::middleware(['auth', 'verified'])->group(function () {

    // --- 1. DASHBOARD UTAMA (REDIRECTOR) ---
    // Ini berfungsi sebagai "Lampu Merah" pengatur lalu lintas role.
    Route::get('/dashboard', function () {
        $role = auth()->user()->user_type;

        // Jika Admin, lempar ke Dashboard Admin
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        // Jika Mitra/Organizer, lempar ke Dashboard Mitra
        elseif ($role === 'organizer') {
            return redirect()->route('mitra.dashboard');
        } 
        // Jika User biasa (attendee), biarkan di sini (tampilkan view dashboard default)
        else {
            return view('dashboard'); 
        }
    })->name('dashboard');


    // --- 2. PROFILE USER (Bawaan Breeze) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // --- 3. AREA KHUSUS ATTENDEE (PEMBELI) ---
    // User biasa tidak butuh dashboard khusus karena mereka pakai default,
    // tapi nanti kita butuh route untuk tiket saya, history, dll.
    Route::middleware('role:attendee')->group(function () {
        // Contoh: Route::get('/my-tickets', ...);
    });


    // --- 4. AREA KHUSUS ORGANIZER (MITRA) ---
    Route::middleware('role:organizer')->group(function () {
        
        // Dashboard khusus Mitra
        // Panggil fungsi index di EventController
        Route::get('/mitra/dashboard', [EventController::class, 'index'])->name('mitra.dashboard');
        // 1. Route untuk menampilkan formulir
        Route::get('/mitra/events/create', [EventController::class, 'create'])->name('mitra.events.create');
        // 2. Route untuk memproses data form (simpan ke db)
        Route::post('/mitra/events', [EventController::class, 'store'])->name('mitra.events.store');
        // 3. Form Edit
        Route::get('/mitra/events/{id}/edit', [EventController::class, 'edit'])->name('mitra.events.edit');
        // 4. Proses Update (Pakai PUT)
        Route::put('/mitra/events/{id}', [EventController::class, 'update'])->name('mitra.events.update');
        // 5. Proses Hapus (Pakai DELETE)
        Route::delete('/mitra/events/{id}', [EventController::class, 'destroy'])->name('mitra.events.destroy');
    });
        
        // Nanti tambahkan route 'create-event', 'manage-event' di sini
    });


    // --- 5. AREA KHUSUS ADMIN ---
    Route::middleware('role:admin')->group(function () {
        
        // Dashboard khusus Admin
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('admin.dashboard');
        
        // Nanti tambahkan route 'manage-users', 'approve-event' di sini
    });

require __DIR__.'/auth.php';
