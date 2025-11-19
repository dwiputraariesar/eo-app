<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="mb-4 text-green-500">
                    <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h2>
                <p class="text-gray-600 mb-6">Terima kasih, tiket Anda sudah aktif.</p>
                
                <a href="{{ route('bookings.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Lihat Tiket Saya
                </a>
            </div>
        </div>
    </div>
</x-app-layout>