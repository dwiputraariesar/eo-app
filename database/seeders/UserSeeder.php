<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'first_name' => 'Super',
            'last_name'  => 'Admin',
            'email'      => 'admin@example.com',
            'phone'      => '081234567890',
            'password'   => Hash::make('password'), // Password-nya: password
            'user_type'  => 'admin',
            'is_active'  => true,
        ]);

        // 2. Buat Akun MITRA (Organizer)
        User::create([
            'first_name' => 'Mitra',
            'last_name'  => 'Event',
            'email'      => 'mitra@example.com',
            'phone'      => '089876543210',
            'password'   => Hash::make('password'),
            'user_type'  => 'organizer',
            'is_active'  => true,
        ]);

        // 3. Buat Akun USER (Attendee/Pembeli)
        User::create([
            'first_name' => 'User',
            'last_name'  => 'Biasa',
            'email'      => 'user@example.com',
            'phone'      => '085678901234',
            'password'   => Hash::make('password'),
            'user_type'  => 'attendee',
            'is_active'  => true,
        ]);
    }
}