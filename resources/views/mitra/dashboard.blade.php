<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Dashboard Mitra') }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">Kelola event dan pantau penjualan tiket Anda.</p>
            </div>

            {{-- Tombol Buat Event Baru --}}
            <a href="{{ route('mitra.events.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-blue-500 bg-gray-800 rounded-lg hover:bg-gray-700 transition border border-blue-500/30 hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Event Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-blue-500 border border-blue-500/50 rounded-lg bg-gray-800/50 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            {{-- Statistik Ringkas --}}
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Statistik Event</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Total Events --}}
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Event</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $events->count() }}</h3>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Published Events --}}
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Event Tayang</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $events->where('status', 'published')->count() }}</h3>
                            </div>
                            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- Draft Events --}}
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Draft Event</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $events->where('status', 'draft')->count() }}</h3>
                            </div>
                            <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="bg-gray-800 rounded-xl border border-blue-500/20">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-white mb-6">Daftar Event Saya</h3>

                    @if($events->isEmpty())
                        {{-- Empty State --}}
                        <div class="text-center py-16">
                            <div class="bg-gray-700 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white">Belum ada event</h3>
                            <p class="mt-1 text-gray-400">Mulai buat event pertama Anda sekarang juga.</p>
                            <div class="mt-6">
                                <a href="{{ route('mitra.events.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-500 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-600 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Buat Event Pertama
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Data Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-700">
                                        <th class="p-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Event</th>
                                        <th class="p-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Info</th>
                                        <th class="p-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Harga & Kapasitas</th>
                                        <th class="p-4 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                        <th class="p-4 text-xs font-medium text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition duration-150">
                                        {{-- Kolom Gambar & Judul --}}
                                        <td class="p-4 align-top">
                                            <div class="flex items-start gap-4">
                                                <div class="w-16 h-16 flex-shrink-0 bg-gray-700 rounded-lg overflow-hidden">
                                                    @if($event->banner_image_url)
                                                        <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover" alt="Poster">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xl">📅</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-white line-clamp-1">{{ $event->title }}</div>
                                                    <div class="text-xs text-blue-400 bg-blue-500/20 inline-block px-2 py-0.5 rounded mt-1 font-medium border border-blue-500/30">
                                                        {{ $event->category->name ?? 'Kategori' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom Info Tanggal & Lokasi --}}
                                        <td class="p-4 text-sm align-top text-gray-300">
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="truncate max-w-[150px]">{{ $event->location }}</span>
                                            </div>
                                        </td>

                                        {{-- Kolom Harga --}}
                                        <td class="p-4 text-sm align-top">
                                            <div class="font-bold text-blue-500">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                Max: {{ $event->max_capacity }} Orang
                                            </div>
                                        </td>

                                        {{-- Kolom Status --}}
                                        <td class="p-4 align-top">
                                            @if($event->status === 'published')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                    <span class="w-2 h-2 mr-1 bg-green-400 rounded-full"></span> Tayang
                                                </span>
                                            @elseif($event->status === 'draft')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                    <span class="w-2 h-2 mr-1 bg-gray-400 rounded-full"></span> Draft
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="p-4 align-top text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Tombol Lihat Peserta --}}
                                                <a href="{{ route('mitra.events.participants', $event->id) }}" title="Lihat Peserta" class="p-2 bg-purple-500/10 text-purple-400 rounded-lg hover:bg-purple-500/20 transition border border-purple-500/30">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('mitra.events.edit', $event->id) }}" title="Edit Event" class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500/20 transition border border-blue-500/30">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('mitra.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini? Data tidak bisa dikembalikan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Event" class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition border border-red-500/30">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
