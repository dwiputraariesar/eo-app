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
    Schema::table('bookings', function (Blueprint $table) {
        // Tambahkan kolom foreign key ke ticket_categories
        // nullable() agar data lama tidak error
        $table->foreignId('ticket_category_id')->nullable()->after('event_id')->constrained('ticket_categories')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
