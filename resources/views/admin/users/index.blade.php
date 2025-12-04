<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Manajemen User') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola semua pengguna dan role di platform.</p>
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

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Berhasil!</span> &nbsp; {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center p-4 mb-6 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="font-medium">Error!</span> &nbsp; {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Users</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $users->total() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 text-purple-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Organizers</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('user_type', 'organizer')->count() }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 text-green-600 rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Attendees</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('user_type', 'attendee')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-6">Daftar Semua Pengguna</h3>

                    @if($users->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Belum ada pengguna</h3>
                            <p class="mt-1 text-gray-500">Daftar pengguna akan muncul di sini.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 border-b border-gray-100 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-medium">User</th>
                                        <th class="p-4 font-medium">Email</th>
                                        <th class="p-4 font-medium">No. HP</th>
                                        <th class="p-4 font-medium">Role</th>
                                        <th class="p-4 font-medium">Terdaftar</th>
                                        <th class="p-4 font-medium text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    @foreach($users as $user)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150">
                                        <!-- User Info -->
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                    <div class="text-xs text-gray-500">ID: {{ $user->id }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Email -->
                                        <td class="p-4 text-gray-600">{{ $user->email }}</td>

                                        <!-- Phone -->
                                        <td class="p-4 text-gray-600">{{ $user->phone_number ?? '-' }}</td>

                                        <!-- Role Badge with Dropdown -->
                                        <td class="p-4">
                                            <form action="{{ route('admin.users.update-role', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <select name="user_type" onchange="if(confirm('Ubah role pengguna ini?')) this.form.submit();"
                                                        class="text-xs font-medium rounded-lg border px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:outline-none
                                                        @if($user->user_type === 'admin') bg-red-50 text-red-800 border-red-200
                                                        @elseif($user->user_type === 'organizer') bg-purple-50 text-purple-800 border-purple-200
                                                        @else bg-blue-50 text-blue-800 border-blue-200 @endif">
                                                    <option value="attendee" {{ $user->user_type === 'attendee' ? 'selected' : '' }}>Attendee</option>
                                                    <option value="organizer" {{ $user->user_type === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                                    <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Registration Date -->
                                        <td class="p-4 text-sm text-gray-600">
                                            {{ $user->created_at->format('d M Y') }}
                                            <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="p-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- Delete Button -->
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                          onsubmit="return confirm('Hapus user {{ $user->first_name }}? Data tidak bisa dikembalikan.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus User"
                                                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition border border-red-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">You</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
