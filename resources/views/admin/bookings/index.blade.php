<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Manajemen Booking & Pembayaran') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Monitor semua transaksi dan pembayaran di platform.</p>
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

            <!-- Revenue Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium">Total Pendapatan (Confirmed)</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-green-600 mt-2">Dari {{ \App\Models\Booking::where('status', 'confirmed')->count() }} booking yang lunas</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium">Menunggu Pembayaran</div>
                    <div class="text-3xl font-bold text-gray-800 mt-1">
                        Rp {{ number_format($pendingRevenue, 0, ',', '.') }}
                    </div>
                    <p class="text-xs text-yellow-600 mt-2">Dari {{ \App\Models\Booking::where('status', 'pending')->count() }} booking pending</p>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-6">Daftar Semua Booking</h3>

                    @if($bookings->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada booking</h3>
                            <p class="mt-1 text-gray-500">Transaksi akan muncul di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-100 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">Kode Booking</th>
                                        <th class="p-4 font-medium">Pemesan</th>
                                        <th class="p-4 font-medium">Event</th>
                                        <th class="p-4 font-medium">Tiket</th>
                                        <th class="p-4 font-medium">Total</th>
                                        <th class="p-4 font-medium">Status</th>
                                        <th class="p-4 font-medium">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach($bookings as $booking)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                                        <!-- Booking Code -->
                                        <td class="p-4">
                                            <div class="font-bold text-gray-900">{{ $booking->confirmation_code }}</div>
                                            <div class="text-xs text-gray-500">ID: {{ $booking->id }}</div>
                                        </td>

                                        <!-- User Info -->
                                        <td class="p-4">
                                            <div class="font-medium text-gray-800">{{ $booking->user->first_name ?? 'Unknown' }} {{ $booking->user->last_name ?? '' }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->user->email ?? '-' }}</div>
                                        </td>

                                        <!-- Event -->
                                        <td class="p-4">
                                            <div class="font-medium text-gray-800 max-w-xs truncate">{{ $booking->event->title ?? 'Event Deleted' }}</div>
                                            @if($booking->ticketCategory)
                                                <div class="text-xs text-purple-600 bg-purple-50 inline-block px-2 py-0.5 rounded mt-1">
                                                    {{ $booking->ticketCategory->name }}
                                                </div>
                                            @endif
                                        </td>

                                        <!-- Quantity -->
                                        <td class="p-4 text-gray-700">{{ $booking->quantity }} tiket</td>

                                        <!-- Total Amount -->
                                        <td class="p-4 font-bold text-gray-900">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>

                                        <!-- Status Badge -->
                                        <td class="p-4">
                                            @if($booking->status === 'confirmed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                    <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span> Lunas
                                                </span>
                                            @elseif($booking->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    <span class="w-2 h-2 mr-1 bg-yellow-500 rounded-full"></span> Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Date -->
                                        <td class="p-4 text-sm text-gray-600">
                                            {{ $booking->created_at?->format('d M Y') ?? 'N/A' }}
                                            <div class="text-xs text-gray-400">{{ $booking->created_at?->format('H:i') ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
