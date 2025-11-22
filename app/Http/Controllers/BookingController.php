<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use App\Models\TicketCategory;

class BookingController extends Controller
{
    /**
     * Memproses pembelian tiket.
     */
    public function store(Request $request, $eventId)
    {
        // 1. Validasi Input
        $request->validate([
            'ticket_category_id' => 'required|exists:ticket_categories,id', // Validasi Kategori
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        $expiredHours = (int) config('services.payment.expired_hours', 24);

        /// 2. Ambil Data Event & Kategori
        $event = Event::findOrFail($eventId);
        $category = TicketCategory::findOrFail($request->ticket_category_id);
        // (Opsional) Cek apakah kategori ini milik event yang benar?
        if($category->event_id != $event->id) {
            return back()->withErrors(['ticket_category_id' => 'Kategori tiket tidak valid.']);
        }
        // (Opsional) Cek Kuota Kategori
        // if($category->quota < $request->quantity) { ... }

        // 3. Hitung Total Harga (Berdasarkan Kategori)
        $quantity = $request->quantity;
        $totalPrice = (int) ($category->price * $quantity);

        // 4. Simpan ke Database Booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'ticket_category_id' => $category->id, // Simpan ID kategori
            'quantity' => $quantity,
            'total_amount' => $totalPrice,
            'status' => 'pending',
            'booking_date' => now(),
            'confirmation_code' => 'BOOK-' . strtoupper(Str::random(10)),
        ]);
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'payment_method' => null,
            'status' => 'pending',
            'transaction_id' => $booking->id,
            'payment_url' => null,
            'va_number' => null ,
        ]);

        $user = Auth::user(); 
        // dd($user);

        // dd("booking : ", $booking, "payment : ", $payment);
        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->withoutVerifying()->post(config('services.payment.base_url') . '/virtual-account/create', [
                'external_id' => (string) $booking->id,
                'amount' => $booking->total_amount,
                'customer_name' => $user->last_name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '081234567890',
                'description' => 'Pembayaran ' . $booking->id,
                'expired_duration' => $expiredHours,
                'callback_url' => route('payment.success', $payment),
                'metadata' => [
                    'product_id' => $booking->id,
                    'user_id' => $user->id,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $payment->update([
                    'va_number' => $data['data']['va_number'],
                    'payment_url' => $data['data']['payment_url'],
                ]);

                return redirect()->route('payment.checkout', $payment);
            } else {
                // dd($payment);
                $payment->update(['status' => 'failed']);
                return redirect()->route('payment.failed',$booking)
                    ->with('error', 'Gagal membuat pembayaran. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return redirect()->route('payment.failed',$payment)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    /**
     * Menampilkan daftar tiket milik User.
     */
    public function index()
    {
        // Ambil booking milik user yang sedang login
        $bookings = Booking::where('user_id', Auth::id())
                           ->with('event')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('bookings.index', compact('bookings'));
    }
}
