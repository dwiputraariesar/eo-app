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
    Schema::create('categories', function (Blueprint $table) {
        $table->id(); // Ini adalah 'category_id' (Primary Key)
        $table->string('name')->unique(); // 'UK' (Unique Key)
        $table->string('description')->nullable(); // nullable() berarti boleh kosong
        $table->boolean('is_active')->default(true);

        // created_at dan updated_at
        // Sangat disarankan oleh Laravel, hapus jika tidak perlu
        $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
