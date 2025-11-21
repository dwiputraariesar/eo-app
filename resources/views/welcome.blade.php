<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Organizer App</title>
    
    {{-- --- BAGIAN BARU: Tambahkan Google Fonts (Montserrat) --- --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    {{-- ------------------------------------------------------- --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 font-sans">
    
    {{-- Navbar Sederhana --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">EO App</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium text-sm transition shadow-md">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section dengan Background dan Logo --}}
    {{-- PENTING: Jangan lupa ganti url gambar background nanti saat Anda sudah punya gambarnya --}}
    <div class="relative bg-blue-600 py-28 text-center text-white bg-cover bg-center" style="background-image: url('path/to/your/background-image.jpg');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">
            {{-- Logo VENTO (Pastikan file ada di public/images/vento-logo-white.png) --}}
            <img src="{{ asset('images/vento-logo-white.png') }}" alt="VENTO Logo" class="w-48 md:w-64 mb-8 mx-auto drop-shadow-lg">
            
            {{-- Head Baru dengan Font Montserrat --}}
            {{-- Perhatikan penambahan class: font-['Montserrat'] dan font-black --}}
            <h1 class="text-5xl md:text-7xl font-['Montserrat'] font-black mb-4 drop-shadow-2xl tracking-wider leading-tight uppercase">
                Catch the Vibe
            </h1>
        </div>
    </div>

    {{-- Daftar Event --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Event Terbaru</h2>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-gray-500 text-lg font-medium">Belum ada event yang tersedia saat ini.</p>
                <p class="text-gray-400 mt-2">Cek kembali nanti untuk update terbaru.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100 flex flex-col h-full">
                    
                    {{-- Gambar Event --}}
                    <div class="h-56 bg-gray-200 relative overflow-hidden group">
                        @if($event->banner_image_url)
                            <img src="{{ Storage::url($event->banner_image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <span class="text-gray-300 text-5xl">🖼️</span>
                            </div>
                        @endif
                        
                        {{-- Badge Kategori & Status --}}
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="px-3 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full shadow-sm backdrop-blur-md bg-opacity-80">
                                {{ $event->category->name ?? 'Umum' }}
                            </span>
                            @if($event->status == 'draft')
                                <span class="px-3 py-1 text-xs font-bold text-gray-600 bg-gray-200 rounded-full shadow-sm backdrop-blur-md bg-opacity-80">DRAFT</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            {{-- Judul --}}
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight line-clamp-2 hover:text-blue-600 transition">
                                <a href="{{ route('events.show', $event->id) }}">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            
                            {{-- Info Tanggal & Lokasi --}}
                            <div class="text-sm text-gray-600 space-y-2 mb-6">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="truncate font-medium">{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Harga & Tombol --}}
                        <div class="flex items-end justify-between mt-auto pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-xs text-gray-500 mb-1 font-medium">Mulai dari</p>
                                <p class="text-xl font-extrabold text-blue-600">
                                    Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center justify-center bg-gray-900 hover:bg-blue-600 text-white text-sm font-bold py-2.5 px-5 rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-12 mt-16 font-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Tentang Kami</h3>
                <p class="text-sm leading-relaxed">Platform terbaik untuk menemukan dan membuat event seru di sekitarmu. Bergabunglah dengan komunitas kami!</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Semua Event</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Kategori</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Bantuan</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">Hubungi Kami</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> support@eoapp.com</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +62 21 555 0100</li>
                </ul>
            </div>
        </div>
        <div class="text-center pt-8 mt-8 border-t border-gray-800 text-sm">
            <p>&copy; {{ date('Y') }} Event Organizer App. All rights reserved. | <a href="#" class="hover:text-blue-400 transition">Privacy Policy</a> | <a href="#" class="hover:text-blue-400 transition">Terms of Service</a></p>
        </div>
    </footer>

</body>
</html>