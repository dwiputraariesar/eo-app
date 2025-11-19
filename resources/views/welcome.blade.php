<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Organizer App</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">
    
    {{-- Navbar Sederhana --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">EO App</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <div class="bg-blue-600 py-20 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Temukan Event Seru di Sekitarmu</h1>
        <p class="text-xl opacity-90">Konser, Seminar, Olahraga, dan banyak lagi.</p>
    </div>

    {{-- Daftar Event --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Event Terbaru</h2>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">Belum ada event yang tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    
                    {{-- Logika Tampilan Gambar --}}
                    <div class="h-48 bg-gray-200 overflow-hidden flex items-center justify-center">
                        @if($event->banner_image_url)
                            {{-- Jika ada gambar, tampilkan dari storage --}}
                            <img src="{{ Storage::url($event->banner_image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        @else
                            {{-- Jika tidak ada, tampilkan placeholder --}}
                            <span class="text-gray-400 text-4xl">🖼️</span>
                        @endif
                    </div>

                    <div class="p-5">
                        {{-- Kategori & Status --}}
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                {{ $event->category->name ?? 'Umum' }}
                            </span>
                            @if($event->status == 'draft')
                                <span class="text-xs font-bold text-gray-500 bg-gray-200 px-2 py-1 rounded">DRAFT</span>
                            @endif
                        </div>

                        {{-- Judul --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">{{ $event->title }}</h3>
                        
                        {{-- Info Tanggal & Lokasi --}}
                        <div class="text-sm text-gray-600 mb-4 space-y-1">
                            <p>📅 {{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y • H:i') }}</p>
                            <p>📍 {{ $event->location }}</p>
                        </div>

                        {{-- Harga & Tombol --}}
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500">Mulai dari</p>
                                <p class="text-lg font-bold text-blue-600">
                                    Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-2 px-4 rounded">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="text-center">
            <p>&copy; {{ date('Y') }} Event Organizer App. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>