<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- JUDUL PERSONAL: Menggunakan Nama Depan User --}}
    <title>{{ Auth::user()->first_name }} - VENTO</title>
    
    {{-- Font Montserrat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 font-sans text-gray-900 flex flex-col min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                
                {{-- Kiri: Logo & Menu --}}
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center mr-8">
                        <img src="{{ asset('images/vento-logo-black.png') }}" alt="VENTO" class="h-8 w-auto">
                    </a>
                    <div class="hidden space-x-8 sm:-my-px sm:flex">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-blue-500 text-sm font-bold leading-5 text-gray-900 focus:outline-none transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                    </div>
                </div>

                {{-- Kanan: Profile --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{-- Nama di Navbar --}}
                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                {{-- Hamburger Mobile --}}
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->first_name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="flex-grow">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- SAPAAN PERSONAL (Nama Depan) --}}
                <div class="mb-8">
                    <h3 class="text-3xl font-['Montserrat'] font-bold text-gray-900">
                        Halo, {{ Auth::user()->first_name }}! 👋
                    </h3>
                    <p class="text-gray-500 mt-2 text-lg">Selamat datang kembali di VENTO.</p>
                </div>

                {{-- Menu Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Kartu 1: Cari Event --}}
                    <a href="{{ route('home') }}" class="group block relative overflow-hidden bg-black rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-black opacity-90"></div>
                        <div class="relative p-8 flex items-center justify-between text-white h-full">
                            <div>
                                <h4 class="text-2xl font-['Montserrat'] font-bold mb-2">Cari Event Baru</h4>
                                <p class="text-gray-300">Jelajahi konser, seminar, dan acara seru lainnya.</p>
                            </div>
                            <div class="bg-white bg-opacity-10 p-4 rounded-full group-hover:bg-opacity-20 transition">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </a>

                    {{-- Kartu 2: Tiket Saya --}}
                    <a href="{{ route('bookings.index') }}" class="group block bg-white border border-gray-200 rounded-2xl shadow-sm hover:border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-8 flex items-center justify-between h-full">
                            <div>
                                <h4 class="text-2xl font-['Montserrat'] font-bold text-gray-900 mb-2">Tiket Saya</h4>
                                <p class="text-gray-500">Lihat riwayat pesanan dan status tiket Anda.</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-full group-hover:bg-blue-600 transition duration-300">
                                <svg class="w-10 h-10 text-blue-600 group-hover:text-white transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-12 mt-auto font-light border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Tentang Kami</h3>
                <p class="text-sm leading-relaxed">Platform terbaik untuk menemukan dan membuat event seru di sekitarmu. Bergabunglah dengan komunitas kami!</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Tautan Cepat</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition">Semua Event</a></li>
                    <li><a href="#" class="hover:text-blue-400 transition">Bantuan</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4 font-['Montserrat']">Hubungi Kami</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg> support@eoapp.com</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> +62 21 555 0100</li>
                </ul>
            </div>
        </div>
        <div class="text-center pt-8 mt-8 border-t border-gray-800 text-sm">
            <p>&copy; {{ date('Y') }} Event Organizer App. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>