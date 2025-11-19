<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                <div class="mb-4 text-red-500">
                    <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Gagal {{ $booking->id }}</h2>
                <p class="text-gray-600 mb-6">Transaksi dibatalkan atau terjadi kesalahan.</p>
                
                <a href="{{ route('payment.checkout', $booking->id) }}" class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded">
                    Coba Bayar Lagi
                </a>
            </div>
        </div>
    </div>
</x-app-layout>