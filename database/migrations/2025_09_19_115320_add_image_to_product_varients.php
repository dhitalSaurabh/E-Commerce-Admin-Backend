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
        Schema::table('product_varients', function (Blueprint $table) {
            $table->dropColumn('additional_price');
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_varients', function (Blueprint $table) {
           // Rollback: Add the 'additional_price' column back
            $table->decimal('additional_price', 10, 2)->default(0);
            
            // Drop the newly added 'image' and 'price' columns
            $table->dropColumn('image');
            $table->dropColumn('price');
        });
    }
};
