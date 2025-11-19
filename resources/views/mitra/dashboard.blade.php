<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Mitra') }}
            </h2>
            {{-- Tombol Buat Event Baru --}}
            <a href="{{ route('mitra.events.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Buat Event Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Sukses (jika ada) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3>Daftar Event Saya</h3>
                    <br>

                    @if($events->isEmpty())
                        <p class="text-center text-gray-500 py-8">Anda belum memiliki event. Silakan buat baru!</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b text-left">Nama Event</th>
                                        <th class="py-2 px-4 border-b text-left">Tanggal</th>
                                        <th class="py-2 px-4 border-b text-left">Lokasi</th>
                                        <th class="py-2 px-4 border-b text-left">Harga</th>
                                        <th class="py-2 px-4 border-b text-left">Status</th>
                                        <th class="py-2 px-4 border-b text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b font-medium">{{ $event->title }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ \Carbon\Carbon::parse($event->start_datetime)->format('d M Y, H:i') }}
                                        </td>
                                        <td class="py-2 px-4 border-b">{{ $event->location }}</td>
                                        <td class="py-2 px-4 border-b">Rp {{ number_format($event->ticket_price, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $event->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                  ($event->status === 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($event->status) }}
                                            </span>
                                        </td>
                                        
                                        {{-- === BAGIAN YANG DIPERBARUI (AKSI) === --}}
                                        <td class="py-2 px-4 border-b flex items-center space-x-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('mitra.events.edit', $event->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium transition">
                                                Edit
                                            </a>

                                            <span class="text-gray-300">|</span>

                                            {{-- Tombol Hapus (Wajib pakai Form & Method DELETE) --}}
                                            <form action="{{ route('mitra.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Data yang dihapus tidak bisa dikembalikan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                        {{-- ===================================== --}}

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