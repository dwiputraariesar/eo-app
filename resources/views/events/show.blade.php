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

            {{-- Kolom Kanan: Pilihan Tiket --}}
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-24 border-t-4 border-blue-600">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">Pilih Tiket</h3>

                    @auth
                        @if(auth()->user()->user_type == 'attendee')
                            
                            <form action="{{ route('bookings.store', $event->id) }}" method="POST">
                                @csrf
                                
                                {{-- Loop Kategori Tiket --}}
                                <div class="space-y-3 mb-6">
                                    @foreach($event->ticketCategories as $category)
                                        <label class="relative block cursor-pointer">
                                            <input type="radio" name="ticket_category_id" value="{{ $category->id }}" class="peer sr-only" required>
                                            
                                            <div class="p-4 rounded-lg border-2 border-gray-200 hover:border-blue-300 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-bold text-gray-800">{{ $category->name }}</span>
                                                    <span class="text-blue-600 font-bold">Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Sisa Kuota: {{ $category->quota }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                {{-- Jumlah Tiket --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
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
                        <div class="space-y-3">
                            @foreach($event->ticketCategories as $category)
                                <div class="p-3 rounded-lg border border-gray-200 bg-gray-50 opacity-75">
                                    <div class="flex justify-between font-medium">
                                        <span>{{ $category->name }}</span>
                                        <span>Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('login') }}" class="block w-full bg-gray-800 hover:bg-gray-900 text-white text-center font-bold py-3 px-4 rounded-lg transition mt-4">
                            Login untuk Membeli
                        </a>
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>

</body>
</html>