<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Tambahkan 'use' untuk model yang terhubung
use App\Models\User;
use App\Models\Event;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan migrasi ...create_reviews_table.php
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'rating',
        'comment',
    ];

    /**
     * Relasi: Satu Review dimiliki oleh satu User.
     * (Relasi 'writes' di ERD)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Review dimiliki oleh satu Event.
     * (Relasi 'gets' di ERD)
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}