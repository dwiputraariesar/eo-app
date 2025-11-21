<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category; 
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        // Ambil event DIMANA organizer_id = ID user yang login
        $events = Event::where('organizer_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // Kirim data $events ke view dashboard
        return view('mitra.dashboard', compact('events'));
    }
    public function create()
    {
        // Ambil kategori yang aktif untuk ditampilkan di dropdown
        $categories = Category::where('is_active', true)->get();
        
        // Tampilkan view (file HTML) formulir
        return view('mitra.events.create', compact('categories'));
    }

    /**
     * Menyimpan event baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'ticket_price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Tambahkan data otomatis (ID Organizer & Status)
        $validated['organizer_id'] = Auth::id(); 
        $validated['status'] = 'draft'; 

        // === BARU: PROSES UPLOAD GAMBAR ===
        if ($request->hasFile('banner_image')) {
            // Simpan file ke folder 'storage/app/public/posters'
            // Fungsi store() mengembalikan path (alamat) file tersebut
            $path = $request->file('banner_image')->store('posters', 'public');
            
            // Simpan path tersebut ke kolom 'banner_image_url' di database
            $validated['banner_image_url'] = $path;
        }

        // 3. Simpan ke Database
        Event::create($validated);

        // 4. Redirect ke dashboard mitra dengan pesan sukses
        return redirect()->route('mitra.dashboard')->with('success', 'Event berhasil dibuat!');
    }
    public function show($id)
    {
        // Cari event berdasarkan ID, jika tidak ketemu tampilkan 404
        $event = Event::findOrFail($id);
        
        // Tampilkan view detail
        return view('events.show', compact('event'));
    }
    /**
     * Menampilkan form edit event.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        // KEAMANAN: Pastikan yang edit adalah pemilik event
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit event ini.');
        }

        $categories = Category::where('is_active', true)->get();

        return view('mitra.events.edit', compact('event', 'categories'));
    }

    /**
     * Memproses update event ke database.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // KEAMANAN: Pastikan pemiliknya benar
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        // 1. Validasi (Gambar tidak wajib/nullable saat edit)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'ticket_price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:draft,published,cancelled', // Bisa ubah status
            'banner_image' => 'nullable|image|max:2048', // Tidak wajib upload ulang
        ]);

        // 2. Cek apakah ada upload gambar baru?
        if ($request->hasFile('banner_image')) {
            // Hapus gambar lama jika ada (Opsional, biar hemat storage)
            // if ($event->banner_image_url) Storage::disk('public')->delete($event->banner_image_url);

            // Simpan gambar baru
            $path = $request->file('banner_image')->store('posters', 'public');
            $validated['banner_image_url'] = $path;
        }

        // 3. Update Data
        $event->update($validated);

        return redirect()->route('mitra.dashboard')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Menghapus event.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // KEAMANAN
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        // Hapus Event
        $event->delete();

        return redirect()->route('mitra.dashboard')->with('success', 'Event berhasil dihapus.');
    }
    /**
     * Menampilkan daftar peserta/pembeli tiket untuk event tertentu.
     */
    public function participants($id)
    {
        $event = Event::findOrFail($id);

        // 1. KEAMANAN: Pastikan hanya pemilik event yang boleh lihat
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat data ini.');
        }

        // 2. Ambil data booking yang terkait dengan event ini
        // Kita gunakan 'with' untuk mengambil data user dan payment sekaligus (Eager Loading)
        $bookings = $event->bookings()
                          ->with(['user', 'payment'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('mitra.events.participants', compact('event', 'bookings'));
    }
}