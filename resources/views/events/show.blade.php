<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - VENTO</title>
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 text-white">

    {{-- Navbar --}}
    <nav class="bg-gray-800 border-b border-blue-500/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-4">
                    <button onclick="window.history.back()" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </button>
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/vento-logo-black.png') }}" alt="VENTO" class="h-8 w-auto brightness-0 invert">
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white font-medium transition px-3 py-2 rounded-lg hover:bg-gray-700/50">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium transition px-3 py-2 rounded-lg hover:bg-gray-700/50">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition shadow-lg hover:shadow-blue-500/50">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Header / Banner --}}
    <div class="relative bg-gray-900 text-white py-24 overflow-hidden">
        {{-- Background Image --}}
        @if($event->banner_image_url)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover opacity-20 blur-sm" alt="Banner Background">
            </div>
        @endif

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-gray-900"></div>

        <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
            <span class="inline-block py-2 px-4 rounded-lg bg-blue-600/90 backdrop-blur-sm text-sm font-bold tracking-wider mb-6 border border-blue-500/30">
                {{ $event->category->name ?? 'Event' }}
            </span>
            <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-2xl font-['Montserrat']">{{ $event->title }}</h1>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-gray-200 text-lg font-medium drop-shadow-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>
                        @if($event->start_datetime)
                            {{ \Carbon\Carbon::parse($event->start_datetime)->format('d F Y, H:i') }}
                        @else
                            TBA
                        @endif
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Poster & Deskripsi --}}
            <div class="md:col-span-2 space-y-6">
                
                {{-- Poster Event --}}
                @if($event->banner_image_url)
                    <div class="bg-gray-800 p-3 rounded-xl border border-blue-500/20 overflow-hidden">
                        <img src="{{ Storage::url($event->banner_image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-auto rounded-lg object-cover">
                    </div>
                @endif

                {{-- Deskripsi Event --}}
                <div class="bg-gray-800 p-8 rounded-xl border border-blue-500/20">
                    <h3 class="text-2xl font-bold mb-6 pb-4 border-b border-gray-700 text-white">Deskripsi Event</h3>
                    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed whitespace-pre-line">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Pilihan Tiket --}}
            <div class="md:col-span-1">
                <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 shadow-xl sticky top-24">
                    <h3 class="text-xl font-bold mb-6 text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Pilih Tiket
                    </h3>

                    @auth
                        @if(auth()->user()->user_type == 'attendee')
                            
                            <form action="{{ route('bookings.store', $event->id) }}" method="POST">
                                @csrf
                                
                                {{-- Loop Kategori Tiket --}}
                                <div class="space-y-3 mb-6">
                                    @foreach($event->ticketCategories as $category)
                                        <label class="relative block cursor-pointer">
                                            <input type="radio" name="ticket_category_id" value="{{ $category->id }}" class="peer sr-only" required>
                                            
                                            <div class="p-4 rounded-lg border-2 border-gray-700 hover:border-blue-500/50 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all duration-200">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="font-bold text-white">{{ $category->name }}</span>
                                                    <span class="text-blue-400 font-bold text-lg">Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="text-xs text-gray-400 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                    Sisa Kuota: <span class="font-semibold text-gray-300">{{ $category->quota }}</span>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                {{-- Jumlah Tiket --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-300 mb-2">Jumlah Tiket</label>
                                    <select name="quantity" class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2.5 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition">
                                        <option value="1">1 Tiket</option>
                                        <option value="2">2 Tiket</option>
                                        <option value="3">3 Tiket</option>
                                        <option value="4">4 Tiket</option>
                                        <option value="5">5 Tiket</option>
                                    </select>
                                </div>

                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-lg transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Beli Tiket Sekarang
                                </button>
                            </form>

                        @elseif(auth()->user()->user_type == 'organizer')
                             <div class="bg-blue-500/10 border border-blue-500/30 text-blue-400 p-4 rounded-lg text-sm text-center">
                                <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ini adalah event Anda (Mode Mitra).
                            </div>
                        @else
                            <div class="bg-gray-700 border border-gray-600 text-gray-300 p-4 rounded-lg text-sm text-center">
                                Admin Mode
                            </div>
                        @endif
                    @else
                        <div class="space-y-3 mb-6">
                            @foreach($event->ticketCategories as $category)
                                <div class="p-4 rounded-lg border border-gray-700 bg-gray-700/50 opacity-75">
                                    <div class="flex justify-between font-medium text-gray-300">
                                        <span>{{ $category->name }}</span>
                                        <span class="text-blue-400">Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('login') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white text-center font-bold py-3.5 px-4 rounded-lg transition border border-gray-600 hover:border-gray-500">
                            Login untuk Membeli
                        </a>
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>

</body>
</html>
