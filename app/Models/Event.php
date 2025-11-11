<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Tambahkan 'use' untuk SEMUA model yang terhubung
use App\Models\User;
use App\Models\Category;
use App\Models\Booking;
use App\Models\Review;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan migrasi ...create_events_table.php
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_datetime',
        'end_datetime',
        'location',
        'ticket_price',
        'max_capacity',
        'banner_image_url',
        'status',
        'organizer_id', // Foreign Key
        'category_id',  // Foreign Key
    ];

    /**
     * Relasi: Satu Event dimiliki oleh satu User (Organizer).
     * (Relasi 'organizes' di ERD)
     */
    public function organizer()
    {
        // 'organizer_id' adalah foreign key di tabel 'events'
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Relasi: Satu Event dimiliki oleh satu Category.
     * (Relasi 'categorizes' di ERD)
     */
    public function category()
    {
        // 'category_id' adalah foreign key di tabel 'events'
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Satu Event memiliki banyak Booking.
     * (Relasi 'receives' di ERD)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi: Satu Event memiliki banyak Review.
     * (Relasi 'gets' di ERD)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}