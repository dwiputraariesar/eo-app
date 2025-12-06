<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // 1. Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'banner_image' => 'nullable|image|max:2048',
            
            // Validasi Array Tiket
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
        ]);

        // 2. Upload Gambar
        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('posters', 'public');
        }

        // 3. Simpan Event (Induk)
        // Trik: Kita isi ticket_price & max_capacity di tabel events dengan 
        // harga terendah & total kapasitas dari inputan, agar halaman depan tidak error.
        $minPrice = min(array_column($request->tickets, 'price'));
        $totalQuota = array_sum(array_column($request->tickets, 'quota'));

        $event = Event::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'location' => $request->location,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'banner_image_url' => $bannerPath,
            'organizer_id' => Auth::id(),
            'status' => 'draft',
            
            // Data pelengkap untuk backward compatibility
            'ticket_price' => $minPrice, 
            'max_capacity' => $totalQuota, 
        ]);

        // 4. Simpan Kategori Tiket (Anak)
        foreach ($request->tickets as $ticketData) {
            $event->ticketCategories()->create([
                'name' => $ticketData['name'],
                'price' => $ticketData['price'],
                'quota' => $ticketData['quota'],
            ]);
        }

        return redirect()->route('mitra.dashboard')->with('success', 'Event berhasil dibuat dengan variasi tiket!');
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

    /**
     * Menampilkan halaman hasil penjualan event untuk organizer.
     */
    public function sales()
    {
        $organizerId = Auth::id();

        // Ambil semua event milik organizer
        $events = Event::where('organizer_id', $organizerId)
            ->with(['bookings' => function($query) {
                $query->with('user', 'ticketCategory');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik keseluruhan
        $totalRevenue = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
        ->where('status', 'confirmed')
        ->sum('total_amount');

        $pendingRevenue = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
        ->where('status', 'pending')
        ->sum('total_amount');

        $totalBookings = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->count();

        $confirmedBookings = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
        ->where('status', 'confirmed')
        ->count();

        $pendingBookings = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
        ->where('status', 'pending')
        ->count();

        // Hitung pendapatan per event
        $eventSales = collect([]);
        foreach ($events as $event) {
            $confirmedSales = $event->bookings()->where('status', 'confirmed')->sum('total_amount');
            $pendingSales = $event->bookings()->where('status', 'pending')->sum('total_amount');
            $totalTicketsSold = $event->bookings()->where('status', 'confirmed')->sum('quantity');
            $totalBookingsCount = $event->bookings()->count();
            $confirmedBookingsCount = $event->bookings()->where('status', 'confirmed')->count();

            $eventSales->push([
                'event' => $event,
                'confirmed_revenue' => $confirmedSales,
                'pending_revenue' => $pendingSales,
                'total_tickets_sold' => $totalTicketsSold,
                'total_bookings' => $totalBookingsCount,
                'confirmed_bookings' => $confirmedBookingsCount,
            ]);
        }

        // Data untuk grafik pendapatan 6 bulan terakhir
        $revenueData = [];
        $revenueLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueLabels[] = $date->format('M Y');
            $revenueData[] = Booking::whereHas('event', function($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->where('status', 'confirmed')
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->sum('total_amount');
        }

        // Booking terbaru
        $recentBookings = Booking::whereHas('event', function($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })
        ->with(['user', 'event', 'ticketCategory'])
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();

        return view('mitra.sales', compact(
            'events',
            'totalRevenue',
            'pendingRevenue',
            'totalBookings',
            'confirmedBookings',
            'pendingBookings',
            'eventSales',
            'revenueData',
            'revenueLabels',
            'recentBookings'
        ));
    }
}