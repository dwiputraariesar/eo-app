<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VENTO - Event Organizer Platform</title>
    
    {{-- Google Fonts (Montserrat) --- --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .particle {
            will-change: transform, opacity;
            animation: float 20s infinite ease-in-out;
        }
        
        @keyframes float {
            0% {
                transform: translate(0, 0) rotate(0deg);
                opacity: 0.3;
            }
            25% {
                transform: translate(var(--tx1, 30px), var(--ty1, -40px)) rotate(90deg);
                opacity: 0.5;
            }
            50% {
                transform: translate(var(--tx2, -25px), var(--ty2, -80px)) rotate(180deg);
                opacity: 0.2;
            }
            75% {
                transform: translate(var(--tx3, 35px), var(--ty3, -50px)) rotate(270deg);
                opacity: 0.4;
            }
            100% {
                transform: translate(0, 0) rotate(360deg);
                opacity: 0.3;
            }
        }
        
        .particle:nth-child(odd) {
            animation-direction: reverse;
            animation-duration: 25s;
        }
        
        .particle:nth-child(3n) {
            animation-duration: 18s;
        }
        
        .particle:nth-child(4n) {
            animation-duration: 22s;
        }
        
        #cursor-flare {
            will-change: transform, opacity;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroSection = document.getElementById('hero-section');
            const cursorFlare = document.getElementById('cursor-flare');
            
            if (heroSection && cursorFlare) {
                let mouseX = 0;
                let mouseY = 0;
                let flareX = 0;
                let flareY = 0;
                
                heroSection.addEventListener('mousemove', (e) => {
                    const rect = heroSection.getBoundingClientRect();
                    mouseX = e.clientX - rect.left;
                    mouseY = e.clientY - rect.top;
                    
                    cursorFlare.style.opacity = '1';
                });
                
                heroSection.addEventListener('mouseleave', () => {
                    cursorFlare.style.opacity = '0';
                });
                
                function animateFlare() {
                    flareX += (mouseX - flareX) * 0.1;
                    flareY += (mouseY - flareY) * 0.1;
                    
                    cursorFlare.style.left = flareX + 'px';
                    cursorFlare.style.top = flareY + 'px';
                    
                    requestAnimationFrame(animateFlare);
                }
                
                animateFlare();
            }
        });
    </script>
</head>
<body class="antialiased bg-gray-900 font-sans">
    
    {{-- Navbar --}}
    <nav class="bg-gray-800 border-b border-blue-500/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/vento-logo-black.png') }}" alt="VENTO" class="h-8 w-auto brightness-0 invert">
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white font-medium transition px-3 py-2 rounded-lg hover:bg-gray-700/50">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium transition px-3 py-2 rounded-lg hover:bg-gray-700/50">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-lg hover:shadow-blue-500/50">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section dengan Background Main --}}
    <div id="hero-section" class="relative bg-gray-900 py-20 text-center text-white overflow-hidden">
        {{-- Cursor Flare Effect --}}
        <div id="cursor-flare" class="absolute w-96 h-96 rounded-full pointer-events-none opacity-0 transition-opacity duration-300" style="
            background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, rgba(59, 130, 246, 0.2) 50%, transparent 70%);
            filter: blur(60px);
            transform: translate(-50%, -50%);
        "></div>
        
        {{-- Animated background elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/20 rounded-full blur-3xl"></div>
        </div>
        
        {{-- Ornamen Debu yang Bergerak --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            @php
                $particles = [];
                for($i = 0; $i < 25; $i++) {
                    $particles[] = [
                        'left' => rand(0, 100),
                        'top' => rand(0, 100),
                        'tx1' => rand(-40, 40),
                        'ty1' => rand(-60, -20),
                        'tx2' => rand(-40, 40),
                        'ty2' => rand(-100, -60),
                        'tx3' => rand(-40, 40),
                        'ty3' => rand(-60, -20),
                        'delay' => rand(0, 8),
                        'size' => rand(2, 4),
                        'opacity' => 0.2 + (rand(0, 6) / 10)
                    ];
                }
            @endphp
            @foreach($particles as $particle)
                <div class="particle absolute bg-white/40 rounded-full blur-[1px]" style="
                    left: {{ $particle['left'] }}%;
                    top: {{ $particle['top'] }}%;
                    width: {{ $particle['size'] }}px;
                    height: {{ $particle['size'] }}px;
                    --tx1: {{ $particle['tx1'] }}px;
                    --ty1: {{ $particle['ty1'] }}px;
                    --tx2: {{ $particle['tx2'] }}px;
                    --ty2: {{ $particle['ty2'] }}px;
                    --tx3: {{ $particle['tx3'] }}px;
                    --ty3: {{ $particle['ty3'] }}px;
                    animation-delay: {{ $particle['delay'] }}s;
                    opacity: {{ $particle['opacity'] }};
                "></div>
            @endforeach
        </div>
        
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-4">
            {{-- LOGO VENTO --}}
            <img src="{{ asset('images/vento-logo-white.png') }}" alt="VENTO Logo" class="w-60 md:w-[350px] mb-4 mx-auto drop-shadow-2xl">
            
            {{-- TEKS TAGLINE --}}
            <h1 class="text-xl md:text-3xl font-['Montserrat'] font-bold drop-shadow-lg tracking-[0.3em] leading-tight uppercase mb-6 text-blue-400">
                Catch the Vibe
            </h1>
            
            {{-- CTA Buttons --}}
            @guest
            <div class="flex flex-col sm:flex-row gap-4 mt-4">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded-lg transition border border-gray-700 hover:border-gray-600">
                    Daftar Sekarang
                </a>
            </div>
            @endguest
        </div>
    </div>

    {{-- Garis Pembatas --}}
    <div class="border-t border-white/20"></div>

    {{-- Daftar Event --}}
    <div id="events" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Event Terbaru</h2>
                <p class="text-gray-400">Temukan event menarik yang sesuai dengan minat Anda</p>
            </div>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-16 bg-gray-800 rounded-xl border border-gray-700">
                <div class="bg-gray-700 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">Belum ada event</h3>
                <p class="text-gray-400">Event akan muncul di sini setelah tersedia.</p>
            </div>
        @else
            {{-- Grid Event Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($events as $event)
                <div class="bg-gray-800 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full overflow-hidden group">
                    
                    {{-- Gambar Event --}}
                    <div class="h-48 bg-gray-700 relative overflow-hidden">
                        @if($event->banner_image_url)
                            <img src="{{ Storage::url($event->banner_image_url) }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                                <span class="text-gray-500 text-5xl">📅</span>
                            </div>
                        @endif
                        
                        {{-- Overlay gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        {{-- Badge Kategori --}}
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-xs font-bold text-white bg-blue-600/90 backdrop-blur-sm rounded-lg shadow-lg">
                                {{ $event->category->name ?? 'Umum' }}
                            </span>
                        </div>
                        
                        {{-- Badge Status --}}
                        @if($event->status === 'published')
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs font-bold text-white bg-green-500/90 backdrop-blur-sm rounded-lg">
                                Live
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            {{-- Judul --}}
                            <h3 class="text-xl font-bold text-white mb-3 leading-snug line-clamp-2 group-hover:text-blue-400 transition">
                                <a href="{{ route('events.show', $event->id) }}">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            
                            {{-- Info Tanggal & Lokasi --}}
                            <div class="text-sm text-gray-400 space-y-2 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">
                                        @if($event->start_datetime)
                                            {{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, H:i') }}
                                        @else
                                            TBA
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate">{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Harga & Tombol --}}
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-700">
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide mb-1">Mulai dari</p>
                                <p class="text-xl font-bold text-blue-400 leading-none">
                                    Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('events.show', $event->id) }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:scale-105">
                                Beli Tiket
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-800 border-t border-gray-700 text-gray-300 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Tentang Kami</h3>
                <p class="text-sm leading-relaxed text-gray-400">Platform terbaik untuk menemukan dan membuat event seru di sekitarmu. Bergabunglah dengan komunitas kami!</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#events" class="hover:text-blue-400 transition">Semua Event</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Kategori</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Bantuan</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Hubungi Kami</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-400">support@eoapp.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-gray-400">+62 21 555 0100</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-center pt-8 mt-8 border-t border-gray-700 text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Event Organizer App. All rights reserved. | <a href="#" class="hover:text-blue-400 transition">Privacy Policy</a> | <a href="#" class="hover:text-blue-400 transition">Terms of Service</a></p>
        </div>
    </footer>

</body>
</html>
