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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id(); // 'review_id' (PK)

        // Foreign Keys
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

        $table->integer('rating'); // Asumsi 1-5
        $table->text('comment')->nullable();

        // ERD Anda punya 'review_date' dan 'created_at', ini agak dobel.
        // Kita pakai timestamps() saja yang sudah mencakup 'created_at'
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
