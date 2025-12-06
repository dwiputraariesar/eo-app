<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Hasil Penjualan Event') }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">Pantau pendapatan dan statistik penjualan tiket Anda.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('mitra.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-gray-400 bg-gray-800 rounded-lg hover:bg-gray-700 transition border border-gray-700 hover:border-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-blue-500 border border-blue-500/50 rounded-lg bg-gray-800/50 backdrop-blur-sm" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            <!-- Statistik Utama -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Ringkasan Penjualan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- Total Pendapatan -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-green-500/20 hover:border-green-500/50 hover:shadow-lg hover:shadow-green-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Pendapatan</p>
                                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                <p class="text-xs text-green-400 mt-2">Dari booking yang sudah lunas</p>
                            </div>
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Pendapatan Pending -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-yellow-500/20 hover:border-yellow-500/50 hover:shadow-lg hover:shadow-yellow-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Pendapatan Pending</p>
                                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</h3>
                                <p class="text-xs text-yellow-400 mt-2">Menunggu konfirmasi pembayaran</p>
                            </div>
                            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Total Booking -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Booking</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalBookings }}</h3>
                                <p class="text-xs text-blue-400 mt-2">{{ $confirmedBookings }} Lunas, {{ $pendingBookings }} Pending</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Total Event -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-purple-500/20 hover:border-purple-500/50 hover:shadow-lg hover:shadow-purple-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Event</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $events->count() }}</h3>
                                <p class="text-xs text-purple-400 mt-2">Event yang Anda miliki</p>
                            </div>
                            <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Grafik Pendapatan -->
            <div class="mb-8">
                <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20">
                    <h3 class="font-bold text-white mb-4">Tren Pendapatan (6 Bulan Terakhir)</h3>
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Penjualan per Event -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Penjualan per Event</h3>
                <div class="bg-gray-800 rounded-xl border border-blue-500/20 overflow-hidden">
                    @if($eventSales->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-700 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white">Belum ada penjualan</h3>
                            <p class="mt-1 text-gray-400">Data penjualan akan muncul di sini setelah ada booking.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-700 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">Event</th>
                                        <th class="p-4 font-medium">Tiket Terjual</th>
                                        <th class="p-4 font-medium">Total Booking</th>
                                        <th class="p-4 font-medium">Pendapatan (Lunas)</th>
                                        <th class="p-4 font-medium">Pendapatan (Pending)</th>
                                        <th class="p-4 font-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-300">
                                    @foreach($eventSales as $sale)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 flex-shrink-0 bg-gray-700 rounded-lg overflow-hidden">
                                                    @if($sale['event']->banner_image_url)
                                                        <img src="{{ Storage::url($sale['event']->banner_image_url) }}" class="w-full h-full object-cover" alt="Event">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-xl">📅</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-white">{{ $sale['event']->title }}</div>
                                                    <div class="text-xs text-gray-400">
                                                        @if($sale['event']->start_datetime)
                                                            {{ \Carbon\Carbon::parse($sale['event']->start_datetime)->format('d M Y') }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-semibold text-blue-400">{{ $sale['total_tickets_sold'] }}</div>
                                            <div class="text-xs text-gray-400">dari {{ $sale['event']->max_capacity ?? 0 }} kapasitas</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-semibold text-white">{{ $sale['total_bookings'] }}</div>
                                            <div class="text-xs text-gray-400">{{ $sale['confirmed_bookings'] }} Lunas</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-bold text-green-400">Rp {{ number_format($sale['confirmed_revenue'], 0, ',', '.') }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-semibold text-yellow-400">Rp {{ number_format($sale['pending_revenue'], 0, ',', '.') }}</div>
                                        </td>
                                        <td class="p-4 text-center">
                                            <a href="{{ route('mitra.events.participants', $sale['event']->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-purple-400 bg-purple-500/10 rounded-lg hover:bg-purple-500/20 transition border border-purple-500/30">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                </svg>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Terbaru -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Transaksi Terbaru</h3>
                <div class="bg-gray-800 rounded-xl border border-blue-500/20">
                    @if($recentBookings->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-400">Belum ada transaksi.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-700 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">Kode Booking</th>
                                        <th class="p-4 font-medium">Pemesan</th>
                                        <th class="p-4 font-medium">Event</th>
                                        <th class="p-4 font-medium">Kategori Tiket</th>
                                        <th class="p-4 font-medium">Jumlah</th>
                                        <th class="p-4 font-medium">Total</th>
                                        <th class="p-4 font-medium">Status</th>
                                        <th class="p-4 font-medium">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-300">
                                    @foreach($recentBookings as $booking)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                                        <td class="p-4">
                                            <div class="font-mono text-xs text-blue-400">{{ $booking->confirmation_code }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-medium text-white">{{ $booking->user->first_name ?? 'Unknown' }} {{ $booking->user->last_name ?? '' }}</div>
                                            <div class="text-xs text-gray-400">{{ $booking->user->email ?? 'N/A' }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="font-medium text-gray-200 truncate max-w-xs">{{ $booking->event->title ?? 'Event Deleted' }}</div>
                                        </td>
                                        <td class="p-4">
                                            <div class="text-sm">{{ $booking->ticketCategory->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="p-4 text-gray-300">{{ $booking->quantity }} tiket</td>
                                        <td class="p-4 font-semibold text-blue-500">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                                        <td class="p-4">
                                            @if($booking->status === 'confirmed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                    <span class="w-2 h-2 mr-1 bg-green-400 rounded-full"></span> Lunas
                                                </span>
                                            @elseif($booking->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                    <span class="w-2 h-2 mr-1 bg-yellow-400 rounded-full"></span> Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-xs text-gray-400">{{ $booking->created_at?->format('d M Y, H:i') ?? 'N/A' }}</td>
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

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Neon Blue Color Palette
        const colors = {
            cyan: 'rgb(34, 211, 238)',
            blue: 'rgb(59, 130, 246)',
            green: 'rgb(74, 222, 128)',
            yellow: 'rgb(250, 204, 21)',
            red: 'rgb(248, 113, 113)',
            purple: 'rgb(168, 85, 247)',
        };

        // Dark mode chart defaults
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = 'rgba(59, 130, 246, 0.1)';

        // Revenue Trend Chart (Line)
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: @json($revenueLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData),
                    borderColor: colors.green,
                    backgroundColor: 'rgba(74, 222, 128, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.green,
                    pointBorderColor: '#1f2937',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: colors.green,
                        bodyColor: '#fff',
                        borderColor: colors.green,
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(74, 222, 128, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>

