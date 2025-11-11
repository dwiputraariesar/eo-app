<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Tambahkan 'use' statement ini
use App\Models\Event;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Sesuai dengan migrasi ...create_categories_table.php
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * Relasi: Satu Category memiliki banyak Event.
     */
    public function events()
    {
        // 'category_id' adalah foreign key di tabel 'events'
        return $this->hasMany(Event::class);
    }
}