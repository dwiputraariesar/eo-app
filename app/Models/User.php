<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Review;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'user_type',
        'is_active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Relasi: Seorang User (Organizer) memiliki banyak Event.
     */
    public function events()
    {
        // 'organizer_id' adalah foreign key di tabel 'events'
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Relasi: Seorang User (Attendee) membuat banyak Booking.
     */
    public function bookings()
    {
        // 'user_id' adalah foreign key di tabel 'bookings'
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi: Seorang User (Attendee) menulis banyak Review.
     */
    public function reviews()
    {
        // 'user_id' adalah foreign key di tabel 'reviews'
        return $this->hasMany(Review::class);
    }
}