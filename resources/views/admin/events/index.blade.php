<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Manajemen Event') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Monitor dan kelola semua event dari seluruh organizer.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white rounded-lg hover:bg-gray-100 transition border border-gray-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 text-purple-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Event</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $events->total() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Published</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Event::where('status', 'published')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-gray-100 text-gray-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Draft</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Event::where('status', 'draft')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-6">Daftar Semua Event</h3>

                    @if($events->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada event</h3>
                            <p class="mt-1 text-gray-500">Event akan muncul di sini ketika organizer membuat event.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-100 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">Event</th>
                                        <th class="p-4 font-medium">Organizer</th>
                                        <th class="p-4 font-medium">Kategori</th>
                                        <th class="p-4 font-medium">Tanggal</th>
                                        <th class="p-4 font-medium">Status</th>
                                        <th class="p-4 font-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach($events as $event)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                                        <!-- Event Info -->
                                        <td class="p-4 align-top">
                                            <div class="flex items-start gap-4">
                                                <div class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden shadow-sm">
                                                    @if($event->banner_image_url)
                                                        <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover" alt="Event">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xl">📅</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 line-clamp-1">{{ $event->title }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($event->description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Organizer -->
                                        <td class="p-4 align-top">
                                            <div class="font-medium text-gray-800">{{ $event->organizer->first_name ?? 'Unknown' }} {{ $event->organizer->last_name ?? '' }}</div>
                                            <div class="text-xs text-gray-500">{{ $event->organizer->email ?? '-' }}</div>
                                        </td>

                                        <!-- Category -->
                                        <td class="p-4 align-top">
                                            <span class="text-xs px-2 py-1 rounded bg-blue-50 text-blue-700 font-medium border border-blue-200">
                                                {{ $event->category->name ?? 'Kategori' }}
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td class="p-4 align-top text-sm text-gray-600">
                                            {{ $event->start_datetime ? \Carbon\Carbon::parse($event->start_datetime)->format('d M Y') : 'N/A' }}
                                            <div class="text-xs text-gray-400">{{ $event->start_datetime ? \Carbon\Carbon::parse($event->start_datetime)->format('H:i') : 'N/A' }}</div>
                                        </td>

                                        <!-- Status with Dropdown -->
                                        <td class="p-4 align-top">
                                            <form action="{{ route('admin.events.update-status', $event->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="if(confirm('Ubah status event ini?')) this.form.submit();"
                                                        class="text-xs font-medium rounded-full px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:outline-none border
                                                        @if($event->status === 'published') bg-green-100 text-green-800 border-green-200
                                                        @elseif($event->status === 'draft') bg-gray-100 text-gray-800 border-gray-200
                                                        @else bg-red-100 text-red-800 border-red-200 @endif">
                                                    <option value="draft" {{ $event->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="published" {{ $event->status === 'published' ? 'selected' : '' }}>Published</option>
                                                    <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Actions -->
                                        <td class="p-4 align-top text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Event -->
                                                <a href="{{ route('events.show', $event->id) }}" target="_blank" title="Lihat Event"
                                                   class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition border border-blue-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>

                                                <!-- Delete Event -->
                                                <form action="{{ route('admin.events.delete', $event->id) }}" method="POST"
                                                      onsubmit="return confirm('Hapus event {{ $event->title }}? Data tidak bisa dikembalikan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus Event"
                                                            class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition border border-red-200">
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

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
