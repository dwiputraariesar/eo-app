<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * 1. Halaman Checkout (Status Booking: PENDING)
     * Di sini user memilih metode pembayaran.
     */
    public function checkout($paymentId)
    {
        $payment = Payment::with('booking')->findOrFail($paymentId);

        // Keamanan: Pastikan yang bayar adalah pemilik booking
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Jika sudah lunas, jangan bayar lagi
        if ($payment->status === 'confirmed') {
            return redirect()->route('bookings.index')->with('success', 'Tiket ini sudah lunas.');
        }

        return view('payment.checkout', compact('payment'));
    }

    /**
     * 2. Proses Simulasi Bayar Sukses (BOOKING SUCCESS)
     */
    public function processSuccess($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // A. Update Status Booking jadi Confirmed
        $booking->update(['status' => 'confirmed']);

        // // B. Catat di Tabel Payments
        // Payment::create([
        //     'booking_id' => $booking->id,
        //     'amount' => $booking->total_amount,
        //     'payment_method' => 'credit_card', // Dummy method
        //     'status' => 'completed',
        //     'transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
        // ]);

        // C. Tampilkan Halaman Sukses
        return view('payment.success', compact('booking'));
    }

    /**
     * 3. Proses Simulasi Bayar Gagal (BOOKING FAILED)
     */
    public function processFailed($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Status booking tetap 'pending' atau diubah ke 'cancelled'
        // Di sini kita biarkan pending agar user bisa coba bayar lagi
        
        // Catat percobaan gagal di payments (Opsional)
        // Payment::create([
        //     'booking_id' => $booking->id,
        //     'amount' => $booking->total_amount,
        //     'payment_method' => 'credit_card',
        //     'status' => 'failed',
        //     'transaction_id' => 'FAIL-' . strtoupper(Str::random(10)),
        // ]);

        return view('payment.failed', compact('booking'));
    }
}