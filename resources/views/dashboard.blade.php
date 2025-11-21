<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Ucapan Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->first_name }}! 👋</h3>
                    <p class="text-gray-600">Selamat datang kembali. Apa rencana seru Anda hari ini?</p>
                </div>
            </div>

            {{-- Menu Utama (Grid) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Kartu 1: Cari Event --}}
                <a href="{{ route('home') }}" class="group block bg-blue-600 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <div class="p-8 flex items-center justify-between text-white">
                        <div>
                            <h4 class="text-xl font-bold mb-2">Cari Event Baru</h4>
                            <p class="text-blue-100 text-sm">Jelajahi konser, seminar, dan acara seru lainnya.</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </a>

                {{-- Kartu 2: Tiket Saya --}}
                <a href="{{ route('bookings.index') }}" class="group block bg-white border border-gray-200 overflow-hidden shadow-sm sm:rounded-lg hover:border-blue-500 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                    <div class="p-8 flex items-center justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Tiket Saya</h4>
                            <p class="text-gray-500 text-sm">Lihat riwayat pesanan dan status pembayaran tiket Anda.</p>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-full group-hover:bg-blue-600 transition duration-300">
                            <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                    </div>
                </a>

            </div>

            {{-- Info Tambahan (Opsional) --}}
            <div class="mt-8 text-center text-sm text-gray-400">
                <p>Butuh bantuan? Hubungi customer service kami.</p>
            </div>

        </div>
    </div>
</x-app-layout>