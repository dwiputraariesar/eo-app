<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // Jangan lupa panggil Model Category

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa kategori standar
        $categories = [
            [
                'name' => 'Musik & Konser',
                'description' => 'Pertunjukan musik, konser band, dan festival.',
            ],
            [
                'name' => 'Seminar & Workshop',
                'description' => 'Kegiatan edukasi, pelatihan, dan seminar bisnis.',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Pertandingan olahraga, fun run, dan kompetisi.',
            ],
            [
                'name' => 'Seni & Budaya',
                'description' => 'Pameran seni, teater, dan pertunjukan budaya.',
            ],
            [
                'name' => 'Makanan & Bazaar',
                'description' => 'Festival kuliner dan pasar kaget.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}