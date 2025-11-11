<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Tambahkan 'use' untuk model yang terhubung
use App\Models\Booking;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan migrasi ...create_payments_table.php
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
    ];

    /**
     * Relasi: Satu Payment dimiliki oleh satu Booking.
     * (Relasi 'triggers' di ERD)
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}