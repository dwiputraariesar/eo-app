<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    Halo, {{ Auth::user()->first_name }}! 👋
                </h2>
                <p class="text-sm text-gray-400 mt-1">Selamat datang kembali di VENTO. Jelajahi event menarik dan kelola tiket Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-blue-500 border border-blue-500/50 rounded-lg bg-gray-800/50 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <!-- Cari Event Baru -->
                <a href="{{ route('home') }}" class="group relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl border border-blue-500/30 hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative p-8 flex items-center justify-between text-white h-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-white/20 p-3 rounded-lg group-hover:bg-white/30 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold">Cari Event Baru</h4>
                            </div>
                            <p class="text-blue-100 text-sm leading-relaxed">Jelajahi konser, seminar, workshop, dan acara seru lainnya yang tersedia di platform.</p>
                            <div class="mt-4 flex items-center text-sm font-medium">
                                <span>Jelajahi Sekarang</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Tiket Saya -->
                <a href="{{ route('bookings.index') }}" class="group relative overflow-hidden bg-gray-800 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative p-8 flex items-center justify-between h-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-blue-500/10 p-3 rounded-lg group-hover:bg-blue-500/20 transition border border-blue-500/30">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-bold text-white">Tiket Saya</h4>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed">Lihat riwayat pesanan, status pembayaran, dan detail tiket yang sudah Anda beli.</p>
                            <div class="mt-4 flex items-center text-sm font-medium text-blue-400">
                                <span>Lihat Tiket</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Statistik Cards -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Ringkasan Saya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Total Tiket -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Tiket</p>
                                <h3 class="text-3xl font-bold text-white mt-1">
                                    {{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'confirmed')->sum('quantity') ?? 0 }}
                                </h3>
                                <p class="text-xs text-blue-400 mt-2">Tiket yang sudah dibeli</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Booking Aktif -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-green-500/20 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Booking Aktif</p>
                                <h3 class="text-3xl font-bold text-white mt-1">
                                    {{ \App\Models\Booking::where('user_id', Auth::id())->whereIn('status', ['confirmed', 'pending'])->count() ?? 0 }}
                                </h3>
                                <p class="text-xs text-green-400 mt-2">Pesanan yang masih aktif</p>
                            </div>
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Event Dikunjungi -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-purple-500/20 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Event Dikunjungi</p>
                                <h3 class="text-3xl font-bold text-white mt-1">
                                    {{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'confirmed')->distinct('event_id')->count() ?? 0 }}
                                </h3>
                                <p class="text-xs text-purple-400 mt-2">Event yang sudah diikuti</p>
                            </div>
                            <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Recent Bookings -->
            @php
                $recentBookings = \App\Models\Booking::where('user_id', Auth::id())
                    ->with(['event', 'ticketCategory'])
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @if($recentBookings->isNotEmpty())
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-blue-500">Booking Terbaru</h3>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-blue-400 hover:text-blue-300 transition">
                        Lihat Semua →
                    </a>
                </div>
                <div class="bg-gray-800 rounded-xl border border-blue-500/20 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 border-b border-gray-700 text-xs uppercase tracking-wider">
                                    <th class="p-4 font-medium">Event</th>
                                    <th class="p-4 font-medium">Kategori Tiket</th>
                                    <th class="p-4 font-medium">Jumlah</th>
                                    <th class="p-4 font-medium">Total</th>
                                    <th class="p-4 font-medium">Status</th>
                                    <th class="p-4 font-medium">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-300">
                                @foreach($recentBookings as $booking)
                                <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                                    <td class="p-4">
                                        <div class="font-medium text-white">{{ $booking->event->title ?? 'Event Deleted' }}</div>
                                        <div class="text-xs text-gray-400">{{ $booking->confirmation_code }}</div>
                                    </td>
                                    <td class="p-4">
                                        <span class="text-sm">{{ $booking->ticketCategory->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="p-4 text-gray-300">{{ $booking->quantity }} tiket</td>
                                    <td class="p-4 font-semibold text-blue-400">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                                    <td class="p-4">
                                        @if($booking->status === 'confirmed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                <span class="w-2 h-2 mr-1 bg-green-400 rounded-full"></span> Lunas
                                            </span>
                                        @elseif($booking->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                <span class="w-2 h-2 mr-1 bg-yellow-400 rounded-full"></span> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-xs text-gray-400">{{ $booking->created_at?->format('d M Y') ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Tips -->
            <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl border border-blue-500/20 p-6">
                <div class="flex items-start gap-4">
                    <div class="bg-blue-500/20 p-3 rounded-lg border border-blue-500/30">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-2">Tips untuk Anda</h4>
                        <p class="text-gray-300 text-sm leading-relaxed">
                            Pastikan untuk menyelesaikan pembayaran sebelum batas waktu yang ditentukan. Setelah pembayaran dikonfirmasi, tiket Anda akan tersedia di halaman "Tiket Saya". Jangan lupa untuk datang tepat waktu pada hari event!
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
