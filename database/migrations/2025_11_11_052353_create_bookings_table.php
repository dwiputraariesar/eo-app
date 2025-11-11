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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id(); // 'booking_id' (PK)
        
        // Foreign Keys
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
        
        $table->integer('quantity');
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->dateTime('booking_date');
        $table->string('confirmation_code')->unique(); // 'UK' (Unique)
        
        $table->timestamps(); // 'created_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
