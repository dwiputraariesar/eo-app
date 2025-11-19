<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Error Handling --}}
                    @if ($errors->any())
                        <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mitra.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- WAJIB: Mengubah method POST menjadi PUT --}}

                        {{-- Upload Gambar --}}
                        <div class="mb-6">
                            <label class="block font-medium text-sm text-gray-700">Poster Event (Opsional)</label>
                            @if($event->banner_image_url)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($event->banner_image_url) }}" alt="Current Poster" class="h-32 rounded object-cover">
                                    <p class="text-xs text-gray-500">Gambar saat ini. Upload baru jika ingin mengganti.</p>
                                </div>
                            @endif
                            <input type="file" name="banner_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        {{-- Judul --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Nama Event</label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status (Fitur Tambahan di Edit) --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Status Publikasi</label>
                            <select name="status" class="border-gray-300 rounded-md shadow-sm block w-full mt-1 bg-gray-50">
                                <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>Draft (Disembunyikan)</option>
                                <option value="published" {{ $event->status == 'published' ? 'selected' : '' }}>Published (Tayang)</option>
                                <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="4" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">{{ old('description', $event->description) }}</textarea>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Waktu Mulai</label>
                                <input type="datetime-local" name="start_datetime" value="{{ old('start_datetime', $event->start_datetime) }}" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Waktu Selesai</label>
                                <input type="datetime-local" name="end_datetime" value="{{ old('end_datetime', $event->end_datetime) }}" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Harga Tiket</label>
                                <input type="number" name="ticket_price" value="{{ old('ticket_price', $event->ticket_price) }}" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Kapasitas</label>
                                <input type="number" name="max_capacity" value="{{ old('max_capacity', $event->max_capacity) }}" class="border-gray-300 rounded-md shadow-sm block w-full mt-1">
                            </div>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <a href="{{ route('mitra.dashboard') }}" class="text-gray-600 hover:underline">Batal</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>