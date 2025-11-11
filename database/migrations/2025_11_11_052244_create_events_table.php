<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('events', function (Blueprint $table) {
        $table->id(); // Ini adalah 'event_id' (Primary Key)
        $table->string('title');
        $table->text('description')->nullable();
        $table->dateTime('start_datetime');
        $table->dateTime('end_datetime');
        $table->string('location');
        $table->decimal('ticket_price', 10, 2)->default(0); // Sesuai ERD: ticket_price
        $table->integer('max_capacity');
        $table->string('banner_image_url')->nullable();

        // Kolom 'enum' untuk status
        $table->enum('status', ['draft', 'published', 'cancelled'])->default('draft');

        // --- Foreign Keys (Relasi) ---

        // 1. Relasi ke 'users' (Organizer)
        // constrained('users') berarti terhubung ke 'id' di tabel 'users'
        $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');

        // 2. Relasi ke 'categories'
        // constrained('categories') berarti terhubung ke 'id' di tabel 'categories'
        $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');

        // --- Akhir Foreign Keys ---

        $table->timestamps(); // 'created_at' dan 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
