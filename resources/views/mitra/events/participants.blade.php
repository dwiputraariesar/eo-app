<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Peserta: {{ $event->title }}
            </h2>
            <a href="{{ route('mitra.dashboard') }}" class="text-gray-600 hover:text-gray-900 font-bold text-sm">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Ringkasan Pendapatan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium">Total Tiket Terjual</div>
                    <div class="text-2xl font-bold text-gray-800">
                        {{ $bookings->where('status', 'confirmed')->sum('quantity') }} / {{ $event->max_capacity }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium">Estimasi Pendapatan (Lunas)</div>
                    <div class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($bookings->where('status', 'confirmed')->sum('total_amount'), 0, ',', '.') }}
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium">Menunggu Pembayaran</div>
                    <div class="text-2xl font-bold text-gray-800">
                        Rp {{ number_format($bookings->where('status', 'pending')->sum('total_amount'), 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Tabel Data Peserta --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Daftar Pemesan</h3>

                    @if($bookings->isEmpty())
                        <p class="text-center text-gray-500 py-8">Belum ada yang memesan tiket untuk event ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pemesan</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email / No.HP</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiket</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">
                                                {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">Kode: {{ $booking->confirmation_code }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600">
                                            <div>{{ $booking->user->email }}</div>
                                            <div class="text-xs">{{ $booking->user->phone ?? '-' }}</div>
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-900 font-bold text-center">
                                            {{ $booking->quantity }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-900">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            @if($booking->status == 'confirmed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Lunas
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Batal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-500">
                                            {{ $booking->created_at->format('d M Y H:i') }}
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