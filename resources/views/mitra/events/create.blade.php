<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- PENTING: enctype="multipart/form-data" WAJIB ADA untuk upload file --}}
                    <form action="{{ route('mitra.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 

                        {{-- === INPUT GAMBAR (DISINI POSISINYA) === --}}
                        <div class="mb-6 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                            <label class="block font-bold text-sm text-gray-700 mb-2">Poster Event (Opsional)</label>
                            <input type="file" name="banner_image" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                            ">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB.</p>
                        </div>
                        {{-- ======================================= --}}

                        {{-- Judul Event --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Nama Event</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Kategori</label>
                            <select name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                            <textarea name="description" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>{{ old('description') }}</textarea>
                        </div>

                        {{-- Lokasi --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Waktu Mulai --}}
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Waktu Mulai</label>
                                <input type="datetime-local" name="start_datetime" value="{{ old('start_datetime') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Waktu Selesai --}}
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Waktu Selesai</label>
                                <input type="datetime-local" name="end_datetime" value="{{ old('end_datetime') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Harga --}}
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Harga Tiket (Rp)</label>
                                <input type="number" name="ticket_price" value="{{ old('ticket_price') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>

                            {{-- Kapasitas --}}
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Kapasitas Max</label>
                                <input type="number" name="max_capacity" value="{{ old('max_capacity') }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                Simpan Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>