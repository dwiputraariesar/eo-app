<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->title }} - EO App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-blue-600">EO App</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 font-medium">Log in</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md font-medium text-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Header / Banner (Background Samar) --}}
    <div class="relative bg-gray-900 text-white py-20 overflow-hidden">
        {{-- Background Image (Blur & Gelap) --}}
        @if($event->banner_image_url)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover opacity-30 blur-sm" alt="Banner Background">
            </div>
        @endif

        <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
            <span class="inline-block py-1 px-3 rounded bg-blue-600 text-xs font-bold tracking-wider mb-4">
                {{ $event->category->name ?? 'Event' }}
            </span>
            <h1 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">{{ $event->title }}</h1>
            <p class="text-gray-200 text-lg font-medium drop-shadow-md">
                <span class="mr-4">📅 {{ \Carbon\Carbon::parse($event->start_datetime)->format('d F Y, H:i') }}</span>
                <span>📍 {{ $event->location }}</span>
            </p>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Poster & Deskripsi --}}
            <div class="md:col-span-2">
                
                {{-- === BAGIAN BARU: POSTER JELAS === --}}
                @if($event->banner_image_url)
                    <div class="mb-8 bg-white p-2 rounded-lg shadow-sm border border-gray-100">
                        <img src="{{ Storage::url($event->banner_image_url) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-auto rounded-md object-cover">
                    </div>
                @endif
                {{-- ================================= --}}

                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold mb-4 border-b pb-4 text-gray-800">Deskripsi Event</h3>
                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Info Tiket & Booking --}}
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-24 border-t-4 border-blue-600">
                    <h3 class="text-lg font-bold mb-2 text-gray-800">Informasi Tiket</h3>
                    
                    <div class="mb-6">
                        <p class="text-sm text-gray-500">Harga per tiket</p>
                        <p class="text-3xl font-bold text-blue-600">
                            Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="mb-6 space-y-2 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Kapasitas:</span>
                            <span class="font-semibold">{{ $event->max_capacity }} Orang</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            @if($event->status == 'published')
                                <span class="text-green-600 font-bold">Buka</span>
                            @else
                                <span class="text-gray-500 font-bold">{{ ucfirst($event->status) }}</span>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->user_type == 'attendee')
                            {{-- Form Booking --}}
                            <form action="{{ route('bookings.store', $event->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tiket</label>
                                    <select name="quantity" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="1">1 Tiket</option>
                                        <option value="2">2 Tiket</option>
                                        <option value="3">3 Tiket</option>
                                        <option value="4">4 Tiket</option>
                                        <option value="5">5 Tiket</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md transform hover:-translate-y-1">
                                    Beli Tiket Sekarang
                                </button>
                            </form>
                        @elseif(auth()->user()->user_type == 'organizer')
                             <div class="bg-blue-50 text-blue-800 p-3 rounded text-sm text-center">
                                Ini adalah event Anda (Mode Mitra).
                            </div>
                        @else
                            <div class="bg-gray-100 text-gray-800 p-3 rounded text-sm text-center">
                                Admin Mode
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center font-bold py-3 px-4 rounded-lg transition">
                            Login untuk Membeli
                        </a>
                    @endauth

                </div>
            </div>
        </div>
    </div>

</body>
</html>