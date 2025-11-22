<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Tambahkan 'use' untuk model yang terhubung
use App\Models\User;
use App\Models\Event;
use App\Models\Payment;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan migrasi ...create_bookings_table.php
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_category_id',
        'quantity',
        'total_amount',
        'status',
        'booking_date',
        'confirmation_code',
    ];

    /**
     * Relasi: Satu Booking dimiliki oleh satu User.
     * (Relasi 'makes' di ERD)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Booking dimiliki oleh satu Event.
     * (Relasi 'receives' di ERD)
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relasi: Satu Booking memiliki satu Payment.
     * (Relasi 'triggers' di ERD)
     */
    public function payment()
    {
        // 'booking_id' adalah foreign key di tabel 'payments'
        return $this->hasOne(Payment::class);
    }
    /**
     * Relasi: Booking memiliki satu Kategori Tiket.
     */
    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }
}