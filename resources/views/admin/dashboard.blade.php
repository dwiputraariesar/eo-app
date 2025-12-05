<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">Pusat kontrol dan monitoring aplikasi event organizer.</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.categories') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-blue-500 bg-gray-800 rounded-lg hover:bg-gray-700 transition border border-blue-500/30 hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.users') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-blue-500 bg-gray-800 rounded-lg hover:bg-gray-700 transition border border-blue-500/30 hover:border-blue-400 hover:shadow-lg hover:shadow-blue-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Kelola User
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

            <!-- Statistics Cards Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Statistik Platform</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Total Users -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Pengguna</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalUsers }}</h3>
                                <p class="text-xs text-blue-500 mt-2">+{{ $newUsersThisMonth }} bulan ini</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs">
                            <span class="text-gray-400"><span class="font-semibold text-blue-400">{{ $attendeeCount }}</span> Attendee</span>
                            <span class="text-gray-400"><span class="font-semibold text-blue-400">{{ $organizerCount }}</span> Organizer</span>
                        </div>
                    </div>

                    <!-- Total Events -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Event</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalEvents }}</h3>
                                <p class="text-xs text-blue-500 mt-2">{{ $publishedEvents }} Published</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs">
                            <span class="text-gray-400"><span class="font-semibold text-green-400">{{ $publishedEvents }}</span> Tayang</span>
                            <span class="text-gray-400"><span class="font-semibold text-gray-400">{{ $draftEvents }}</span> Draft</span>
                        </div>
                    </div>

                    <!-- Total Bookings -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Booking</p>
                                <h3 class="text-3xl font-bold text-white mt-1">{{ $totalBookings }}</h3>
                                <p class="text-xs text-blue-500 mt-2">{{ $confirmedBookings }} Lunas</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                        <div class="mt-4 flex gap-4 text-xs">
                            <span class="text-gray-400"><span class="font-semibold text-green-400">{{ $confirmedBookings }}</span> Confirmed</span>
                            <span class="text-gray-400"><span class="font-semibold text-yellow-400">{{ $pendingBookings }}</span> Pending</span>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition group">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Total Pendapatan</p>
                                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                                <p class="text-xs text-yellow-400 mt-2">+Rp {{ number_format($pendingRevenue, 0, ',', '.') }} Pending</p>
                            </div>
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-4 text-xs text-gray-400">
                            <span class="font-semibold text-blue-400">{{ $totalCategories }}</span> Kategori Event
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                    <a href="{{ route('admin.users') }}" class="group bg-gray-800 p-5 rounded-lg border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-white">Kelola User</h4>
                                <p class="text-xs text-gray-400">Edit role & data pengguna</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events') }}" class="group bg-gray-800 p-5 rounded-lg border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-white">Kelola Event</h4>
                                <p class="text-xs text-gray-400">Approve & monitor semua event</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.bookings') }}" class="group bg-gray-800 p-5 rounded-lg border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-white">Lihat Booking</h4>
                                <p class="text-xs text-gray-400">Monitor transaksi & pembayaran</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.categories') }}" class="group bg-gray-800 p-5 rounded-lg border border-blue-500/20 hover:border-blue-500/50 hover:shadow-lg hover:shadow-blue-500/10 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-white">Kelola Kategori</h4>
                                <p class="text-xs text-gray-400">CRUD kategori event</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Analytics Charts Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-blue-500 mb-4">Analitik & Grafik</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Revenue Trend Chart -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/30 transition">
                        <h4 class="font-bold text-white mb-4">Tren Pendapatan (6 Bulan Terakhir)</h4>
                        <div style="height: 280px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- User Registration Trend -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/30 transition">
                        <h4 class="font-bold text-white mb-4">Tren Registrasi User (6 Bulan Terakhir)</h4>
                        <div style="height: 280px;">
                            <canvas id="registrationChart"></canvas>
                        </div>
                    </div>

                    <!-- Events by Category Chart -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/30 transition">
                        <h4 class="font-bold text-white mb-4">Event per Kategori</h4>
                        <div style="height: 280px;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>

                    <!-- Booking Status Distribution -->
                    <div class="bg-gray-800 p-6 rounded-xl border border-blue-500/20 hover:border-blue-500/30 transition">
                        <h4 class="font-bold text-white mb-4">Distribusi Status Booking</h4>
                        <div style="height: 280px;">
                            <canvas id="bookingStatusChart"></canvas>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Recent Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Recent Users -->
                <div class="bg-gray-800 rounded-xl border border-blue-500/20">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-lg text-white">Pengguna Terbaru</h3>
                            <a href="{{ route('admin.users') }}" class="text-sm text-blue-500 hover:text-blue-400">Lihat Semua →</a>
                        </div>

                        @if($recentUsers->isEmpty())
                            <p class="text-center text-gray-400 py-8">Belum ada pengguna terdaftar.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentUsers as $user)
                                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-700/50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($user->user_type === 'admin')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">Admin</span>
                                        @elseif($user->user_type === 'organizer')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">Organizer</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-500/20 text-blue-500 border border-blue-500/30">Attendee</span>
                                        @endif
                                        <div class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Events -->
                <div class="bg-gray-800 rounded-xl border border-blue-500/20">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-lg text-white">Event Terbaru</h3>
                            <a href="{{ route('admin.events') }}" class="text-sm text-blue-500 hover:text-blue-400">Lihat Semua →</a>
                        </div>

                        @if($recentEvents->isEmpty())
                            <p class="text-center text-gray-400 py-8">Belum ada event dibuat.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentEvents as $event)
                                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-700/50 transition">
                                    <div class="w-12 h-12 flex-shrink-0 bg-gray-700 rounded-lg overflow-hidden">
                                        @if($event->banner_image_url)
                                            <img src="{{ Storage::url($event->banner_image_url) }}" class="w-full h-full object-cover" alt="Event">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xl">📅</div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-medium text-white truncate">{{ $event->title }}</div>
                                        <div class="text-xs text-gray-400">oleh {{ $event->organizer->first_name ?? 'Unknown' }}</div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs px-2 py-0.5 rounded bg-blue-500/20 text-blue-500 border border-blue-500/30">{{ $event->category->name ?? 'Kategori' }}</span>
                                            @if($event->status === 'published')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                    <span class="w-1.5 h-1.5 mr-1 bg-green-400 rounded-full"></span> Tayang
                                                </span>
                                            @elseif($event->status === 'draft')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                                    <span class="w-1.5 h-1.5 mr-1 bg-gray-400 rounded-full"></span> Draft
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $event->created_at->diffForHumans() }}</div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Recent Bookings -->
            <div class="mt-6 bg-gray-800 rounded-xl border border-blue-500/20">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-lg text-white">Booking Terbaru</h3>
                        <a href="{{ route('admin.bookings') }}" class="text-sm text-blue-500 hover:text-blue-400">Lihat Semua →</a>
                    </div>

                    @if($recentBookings->isEmpty())
                        <p class="text-center text-gray-400 py-8">Belum ada booking.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-700 text-xs uppercase tracking-wider">
                                        <th class="p-3 font-medium">Pemesan</th>
                                        <th class="p-3 font-medium">Event</th>
                                        <th class="p-3 font-medium">Jumlah</th>
                                        <th class="p-3 font-medium">Total</th>
                                        <th class="p-3 font-medium">Status</th>
                                        <th class="p-3 font-medium">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-300">
                                    @foreach($recentBookings as $booking)
                                    <tr class="border-b border-gray-700/50 hover:bg-gray-700/30 transition">
                                        <td class="p-3">
                                            <div class="font-medium text-white">{{ $booking->user->first_name ?? 'Unknown' }}</div>
                                            <div class="text-xs text-gray-400">{{ $booking->confirmation_code }}</div>
                                        </td>
                                        <td class="p-3">
                                            <div class="font-medium text-gray-200 truncate max-w-xs">{{ $booking->event->title ?? 'Event Deleted' }}</div>
                                        </td>
                                        <td class="p-3 text-gray-300">{{ $booking->quantity }} tiket</td>
                                        <td class="p-3 font-semibold text-blue-500">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                                        <td class="p-3">
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
                                        <td class="p-3 text-xs text-gray-400">{{ $booking->created_at->diffForHumans() }}</td>
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

        // 1. Revenue Trend Chart (Line)
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: @json($revenueLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData),
                    borderColor: colors.blue,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.blue,
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
                        titleColor: colors.blue,
                        bodyColor: '#fff',
                        borderColor: colors.blue,
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
                            color: 'rgba(59, 130, 246, 0.05)'
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

        // 2. User Registration Trend (Line)
        new Chart(document.getElementById('registrationChart'), {
            type: 'line',
            data: {
                labels: @json($registrationLabels),
                datasets: [{
                    label: 'Registrasi User',
                    data: @json($registrationData),
                    borderColor: colors.blue,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colors.blue,
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
                        titleColor: colors.blue,
                        bodyColor: '#fff',
                        borderColor: colors.blue,
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(59, 130, 246, 0.05)'
                        },
                        ticks: {
                            stepSize: 1
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

        // 3. Events by Category (Bar)
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Jumlah Event',
                    data: @json($categoryValues),
                    backgroundColor: [colors.blue, colors.green, colors.yellow, colors.purple, colors.red],
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: colors.blue,
                        bodyColor: '#fff',
                        borderColor: colors.blue,
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(59, 130, 246, 0.05)'
                        },
                        ticks: {
                            stepSize: 1
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

        // 4. Booking Status Distribution (Doughnut)
        new Chart(document.getElementById('bookingStatusChart'), {
            type: 'doughnut',
            data: {
                labels: @json($bookingStatusLabels),
                datasets: [{
                    data: @json($bookingStatusData),
                    backgroundColor: [colors.green, colors.yellow, colors.red],
                    borderWidth: 0,
                    borderColor: '#1f2937'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            },
                            color: '#9ca3af'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: colors.blue,
                        bodyColor: '#fff',
                        borderColor: colors.blue,
                        borderWidth: 1
                    }
                }
            }
        });
    </script>
</x-app-layout>
