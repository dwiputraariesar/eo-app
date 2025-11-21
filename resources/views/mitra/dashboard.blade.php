<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Dashboard Mitra') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola event dan pantau penjualan tiket Anda.</p>
            </div>
            
            {{-- Tombol Buat Event Baru (Dengan Style Gradient) --}}
            <a href="{{ route('mitra.events.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white transition-all duration-200 bg-blue-600 rounded-full hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                <span class="mr-2 text-xl">+</span> Buat Event Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Event</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $events->count() }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Event Tayang (Published)</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $events->where('status', 'published')->count() }}</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Draft Event</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $events->where('status', 'draft')->count() }}</h3>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-6">Daftar Event Saya</h3>

                    @if($events->isEmpty())
                        {{-- Empty State --}}
                        <div class="text-center py-16">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada event</h3>
                            <p class="mt-1 text-gray-500">Mulai buat event pertama Anda sekarang juga.</p>
                            <div class="mt-6">
                                <a href="{{ route('mitra.events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    + Buat Event Pertama
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Data Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-100 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">Event</th>
                                        <th class="p-4 font-medium">Info</th>
                                        <th class="p-4 font-medium">Harga & Kapasitas</th>
                                        <th class="p-4 font-medium">Status</th>
                                        <th class="p-4 font-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach($events as $event)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                                        {{-- Kolom Gambar & Judul --}}
                                        <td class="p-4 align-top">
                                            <div class="flex items-start gap-4">
                                                <div class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden shadow-sm">
                                                    @if($event->banner_image_url)
                                                        <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover" alt="Poster">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xl">📅</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 line-clamp-1">{{ $event->title }}</div>
                                                    <div class="text-xs text-blue-600 bg-blue-50 inline-block px-2 py-0.5 rounded mt-1 font-medium">
                                                        {{ $event->category->name ?? 'Kategori' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom Info Tanggal & Lokasi --}}
                                        <td class="p-4 text-sm align-top">
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span class="truncate max-w-[150px]">{{ $event->location }}</span>
                                            </div>
                                        </td>

                                        {{-- Kolom Harga --}}
                                        <td class="p-4 text-sm align-top">
                                            <div class="font-bold text-gray-800">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Max: {{ $event->max_capacity }} Orang
                                            </div>
                                        </td>

                                        {{-- Kolom Status --}}
                                        <td class="p-4 align-top">
                                            @if($event->status === 'published')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span> Tayang
                                                </span>
                                            @elseif($event->status === 'draft')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                    <span class="w-2 h-2 mr-1 bg-gray-500 rounded-full"></span> Draft
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="p-4 align-top text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                {{-- Tombol Lihat Peserta --}}
                                                <a href="{{ route('mitra.events.participants', $event->id) }}" title="Lihat Peserta" class="p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition border border-indigo-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                </a>

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('mitra.events.edit', $event->id) }}" title="Edit Event" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('mitra.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus event ini? Data tidak bisa dikembalikan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Event" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition border border-red-200">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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