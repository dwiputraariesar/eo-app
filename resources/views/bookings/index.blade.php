<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tiket Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($bookings->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 mb-4">Belum ada tiket yang dipesan.</p>
                            <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Cari Event Sekarang
                            </a>
                        </div>
                    @else
                        <div class="grid gap-6">
                            @foreach($bookings as $booking)
                                <div class="border rounded-lg p-4 flex flex-col md:flex-row justify-between items-center hover:shadow-md transition bg-gray-50">
                                    
                                    {{-- Info Event --}}
                                    <div class="flex-1">
                                        <div class="text-xs text-gray-500 mb-1">
                                            Kode Booking: <span class="font-mono font-bold text-gray-700">{{ $booking->confirmation_code }}</span>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-lg font-bold text-blue-600">
                                                {{ $booking->event->title ?? 'Event Tidak Ditemukan' }}
                                            </h3>
                                            
                                            {{-- TAMPILKAN JENIS TIKET (BARU) --}}
                                            @if($booking->ticketCategory)
                                                <span class="px-2 py-0.5 rounded text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                                    {{ $booking->ticketCategory->name }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($booking->event)
                                            <p class="text-sm text-gray-600">
                                                📅 {{ \Carbon\Carbon::parse($booking->event->start_datetime)->format('d M Y, H:i') }} <br>
                                                📍 {{ $booking->event->location }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Info Transaksi & Status --}}
                                    <div class="text-right mt-4 md:mt-0 md:ml-6">
                                        <div class="text-sm text-gray-500">Total ({{ $booking->quantity }} tiket)</div>
                                        <div class="text-xl font-bold text-gray-900 mb-2">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </div>
                                        
                                        <div>
                                            @if($booking->status == 'pending')
                                                {{-- Status Pending --}}
                                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold mr-2">
                                                    Menunggu Pembayaran
                                                </span>
                                                
                                                {{-- TOMBOL BAYAR (Ini yang mengarah ke Checkout) --}}
                                                <a href="{{ route('payment.checkout', $booking->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded transition">
                                                    Bayar Sekarang
                                                </a>

                                            @elseif($booking->status == 'confirmed')
                                                {{-- Status Lunas --}}
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">
                                                    Lunas / Aktif
                                                </span>
                                                {{-- Tombol Cetak Tiket (Nanti) --}}
                                                <button class="ml-2 text-xs text-gray-500 underline hover:text-gray-800">Cetak Tiket</button>

                                            @else
                                                {{-- Status Batal --}}
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-bold">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>