<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    Tiket Saya
                </h2>
                <p class="text-sm text-gray-400 mt-1">Kelola dan lihat semua tiket yang sudah Anda beli.</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-blue-500 bg-gray-800 rounded-lg hover:bg-gray-700 transition border border-blue-500/30 hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari Event Lain
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-blue-500 border border-blue-500/50 rounded-lg bg-gray-800/50 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            @if($bookings->isEmpty())
                {{-- Empty State --}}
                <div class="text-center py-16 bg-gray-800 rounded-xl border border-gray-700">
                    <div class="bg-gray-700 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-white mb-2">Belum ada tiket yang dipesan</h3>
                    <p class="text-gray-400 mb-6">Mulai jelajahi event menarik dan beli tiket pertama Anda!</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-blue-500/50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Event Sekarang
                    </a>
                </div>
            @else
                {{-- Booking Cards --}}
                <div class="grid gap-6">
                    @foreach($bookings as $booking)
                        <div class="bg-gray-800 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                
                                {{-- Info Event --}}
                                <div class="flex-1 flex items-start gap-4">
                                    {{-- Event Image --}}
                                    @if($booking->event && $booking->event->banner_image_url)
                                        <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden border border-gray-700">
                                            <img src="{{ Storage::url($booking->event->banner_image_url) }}" alt="{{ $booking->event->title }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-24 h-24 flex-shrink-0 rounded-lg bg-gray-700 flex items-center justify-center border border-gray-600">
                                            <span class="text-3xl">📅</span>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs text-gray-500 mb-2 font-mono">
                                            Kode: <span class="font-bold text-blue-400">{{ $booking->confirmation_code }}</span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                                            <h3 class="text-xl font-bold text-white">
                                                {{ $booking->event->title ?? 'Event Tidak Ditemukan' }}
                                            </h3>
                                            
                                            {{-- Badge Kategori Tiket --}}
                                            @if($booking->ticketCategory)
                                                <span class="px-3 py-1 rounded-lg text-xs font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                                    {{ $booking->ticketCategory->name }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($booking->event)
                                            <div class="space-y-1.5 text-sm text-gray-400">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>
                                                        @if($booking->event->start_datetime)
                                                            {{ \Carbon\Carbon::parse($booking->event->start_datetime)->format('d M Y, H:i') }}
                                                        @else
                                                            TBA
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="truncate">{{ $booking->event->location }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Info Transaksi & Status --}}
                                <div class="text-right md:text-left md:min-w-[200px]">
                                    <div class="text-sm text-gray-400 mb-1">Total ({{ $booking->quantity }} tiket)</div>
                                    <div class="text-2xl font-bold text-blue-400 mb-4">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </div>
                                    
                                    <div class="flex flex-col items-end md:items-start gap-2">
                                        @if($booking->status == 'pending')
                                            {{-- Status Pending --}}
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                <span class="w-2 h-2 mr-1.5 bg-yellow-400 rounded-full"></span>
                                                Menunggu Pembayaran
                                            </span>
                                            
                                            {{-- TOMBOL BAYAR --}}
                                            <a href="{{ route('payment.checkout', $booking->id) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded-lg transition shadow-lg hover:shadow-blue-500/50 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Bayar Sekarang
                                            </a>

                                        @elseif($booking->status == 'confirmed')
                                            {{-- Status Lunas --}}
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30">
                                                <span class="w-2 h-2 mr-1.5 bg-green-400 rounded-full"></span>
                                                Lunas / Aktif
                                            </span>
                                            
                                            {{-- Tombol Cetak Tiket --}}
                                            <button onclick="window.print()" class="inline-flex items-center justify-center text-sm text-blue-400 hover:text-blue-300 transition mt-2">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                                Cetak Tiket
                                            </button>

                                        @else
                                            {{-- Status Batal --}}
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">
                                                <span class="w-2 h-2 mr-1.5 bg-red-400 rounded-full"></span>
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
