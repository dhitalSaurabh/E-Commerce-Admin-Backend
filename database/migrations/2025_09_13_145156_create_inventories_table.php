<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('variant_id')
                ->constrained('product_varients') // References product_variants.variant_id
                ->onDelete('cascade'); // ON DELETE CASCADE
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();
        });
    }
    // CREATE TABLE addresses (
//     address_id BIGINT AUTO_INCREMENT PRIMARY KEY,
//     user_id BIGINT NOT NULL,
//     full_name VARCHAR(150),
//     phone VARCHAR(20),
//     street VARCHAR(255),
//     city VARCHAR(100),
//     state VARCHAR(100),
//     postal_code VARCHAR(20),
//     country VARCHAR(100),
//     is_default BOOLEAN DEFAULT FALSE,
//     FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
// );

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
