<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold mb-4">Pembayaran Tiket</h2>
                <p class="text-gray-600 mb-6">Anda akan membayar tiket untuk event: <br> <b>{{ $payment->booking->event->title }}</b></p>
                
                <div class="text-4xl font-bold text-blue-600 mb-8">
                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                </div>

                <div class="space-y-3">
                    {{-- Tombol Simulasi Sukses --}}
                    <form action="{{ route('payment.success', $payment->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded">
                            Bayar Sekarang (Simulasi Sukses)
                        </button>
                    </form>

                    {{-- Tombol Simulasi Gagal --}}
                <div class="mt-4">
                    <a href="{{ $payment->payment_url }}" 
                    target="_blank" 
                    class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center shadow-md transition duration-200">
                        Lanjut Pembayaran (Klik Disini)
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>